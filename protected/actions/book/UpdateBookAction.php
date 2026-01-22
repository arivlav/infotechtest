<?php

class UpdateBookAction implements IControllerAction
{
    public function execute(?int $id = null): array
    {
        $model = BookService::loadModel($id);
        CommonService::performAjaxValidation($model, 'book-form');
        $isSave = false;

        if (isset($_POST['Book'])) {
            $model->attributes = $_POST['Book'];
            $oldImage = $model->image_url;
            ImageService::prepareImageUpload($model);
            $isSave = $model->save();
            if ($isSave) {
                ImageService::finalizeImageUpload($model, $oldImage);
                BookService::updateBookAuthors($model);
            }
        }

        $authorsList = BookService::buildAuthorsList();

        $selectedAuthors = BookService::buildSelectedAuthors($model);

        $data = [
            'model' => $model,
            'authorsList' => $authorsList,
            'selectedAuthors' => $selectedAuthors,
        ];

        return [$isSave, $data];
    }
}