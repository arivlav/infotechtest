<?php

class CommonService
{
    /**
     * Performs the AJAX validation for a model.
     * 
     * @param CActiveRecord $model the model to be validated
     * @param string $formId the form ID to check in POST['ajax']
     * @return void
     */
    public static function performAjaxValidation($model, string $formId): void
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $formId) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
