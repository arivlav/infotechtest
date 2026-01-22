<?php

/**
 * Service for sending SMS via smspilot.ru API
 */
class SmsService
{
    /**
     * Send SMS to subscribers about new book
     *
     * @param int $bookId
     * @return void
     */
    public static function notifySubscribersAboutBook(int $bookId): void
    {
        $book = Book::model()->with('authors')->findByPk($bookId);
        // Send SMS to subscribers
        if ($book !== null) {
            // Get book authors
            $authors = $book->authors;
            if (empty($authors)) {
                return;
            }

            // Get all subscribers for these authors
            $authorIds = [];
            foreach ($authors as $author) {
                $authorIds[] = $author->id;
            }

            if (empty($authorIds)) {
                return;
            }

            $subscribers = Subscription::model()->findAll([
                'condition' => 'author_id IN (' . implode(',', array_map('intval', $authorIds)) . ')',
            ]);

            if (empty($subscribers)) {
                return;
            }

            // Prepare SMS message
            $authorsList = $book->getAuthorsList();
            $bookUrl = Yii::app()->createAbsoluteUrl('book/view', ['id' => $book->id]);
            $message = "Новая книга: \"{$book->title}\" автора: {$authorsList}. Подробнее: {$bookUrl}";

            // Send SMS to each subscriber
            // Get API key from config
            $apiKey = Yii::app()->params['smspilot']['apiKey'];
            // API endpoint
            $url = Yii::app()->params['smspilot']['smsProviderUrl'];
            foreach ($subscribers as $subscriber) {
                self::sendSms($subscriber->phone, $message, $url, $apiKey);
            }
        }
    }

    public static function sendSms(string $phone, string $message, string $url, string $apiKey): bool
    {
        $params = [
            'send' => $message,
            'to' => self::preparePhoneNumber($phone),
            'apikey' => $apiKey,
            'format' => 'json',
        ];

        // Send HTTP request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            Yii::log("SMS sending failed: HTTP {$httpCode}, Response: {$response}", 'error', 'application.SmsService');
            return false;
        }

        $result = json_decode($response, true);
        
        if (isset($result['error'])) {
            Yii::log("SMS sending failed: {$result['error']['description']}", 'error', 'application.SmsService');
            return false;
        }

        Yii::log("SMS sent successfully to {$phone}", 'info', 'application.SmsService');
        return true;
    }

    private static function preparePhoneNumber(string $phone): string
    {
        // Normalize phone number (remove spaces, dashes, etc.)
        $preparedPhone = preg_replace('/[^0-9+]/', '', $phone);

        // If starts with +7, remove +
        if (strpos($preparedPhone, '+7') === 0) {
            $preparedPhone = '7' . substr($preparedPhone, 2);
        }

        // If starts with 8, replace with 7
        if (strpos($preparedPhone, '8') === 0 && strlen($preparedPhone) == 11) {
            $preparedPhone = '7' . substr($preparedPhone, 1);
        }
         return $preparedPhone;
    }
}
