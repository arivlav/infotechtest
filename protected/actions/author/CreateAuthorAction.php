<?php

class CreateAuthorAction implements IControllerAction
{
    public function execute(?int $id = null): array
    {
        $model = new Author();
        CommonService::performAjaxValidation($model, 'author-form');
        $newId = null;

        if (isset($_POST['Author'])) {
            $model->attributes = $_POST['Author'];
            if ($model->save()) {
                $newId = $model->id;
            }
        }

        return [$newId, ['model' => $model]];
    }
}
