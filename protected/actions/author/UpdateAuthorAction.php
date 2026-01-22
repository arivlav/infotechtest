<?php

class UpdateAuthorAction implements IControllerAction
{
    public function execute(?int $id = null): array
    {
        $model = AuthorService::loadModel($id);
        CommonService::performAjaxValidation($model, 'author-form');
        $isSave = false;

        if (isset($_POST['Author'])) {
            $model->attributes = $_POST['Author'];
            $isSave = $model->save();
        }

        return [$isSave, ['model' => $model]];
    }
}
