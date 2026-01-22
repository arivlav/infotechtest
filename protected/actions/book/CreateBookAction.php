<?php

class CreateBookAction implements IControllerAction
{
    public function execute(?int $id = null): array
    {
        $model = new Book();
        CommonService::performAjaxValidation($model, 'book-form');
        $newId = null;

        if (isset($_POST['Book'])) {
            $model->attributes = $_POST['Book'];
            ImageService::prepareImageUpload($model);
            if ($model->save()) {
                ImageService::finalizeImageUpload($model, null);
                BookService::updateBookAuthors($model);
                $newId = $model->id;
                SmsService::notifySubscribersAboutBook($newId);
            }
        }

        $authorsList = BookService::buildAuthorsList();

        $data = [
            'model' => $model,
            'authorsList' => $authorsList,
            'selectedAuthors' => [],
        ];

        return [$newId, $data];
    }
}