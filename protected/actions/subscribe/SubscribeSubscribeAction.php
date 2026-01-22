<?php

class SubscribeSubscribeAction implements IControllerAction
{
    public function execute(?int $id = null): array
    {
        $model = new Subscription();
        $success = false;
        $message = '';

        if (isset($_POST['Subscription'])) {
            $model->attributes = $_POST['Subscription'];
            if ($model->save()) {
                $success = true;
                $message = 'Спасибо за подписку на автора!';
            } else {
                $message = 'Ошибка при сохранении подписки.';
            }
        }

        $data = [
            'success' => $success,
            'message' => $message,
            'errors' => $model->getErrors()
        ];

        return [$success, $message, $data];
    }
}