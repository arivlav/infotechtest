<?php

class RatingBookAction implements IControllerAction
{
    public function execute(?int $id = null): array
    {
        $dataProvider = new CActiveDataProvider('Author', [
            'criteria' => [
                'with' => ['authors'],
            ],
            'pagination' => ['pageSize' => Yii::app()->params['commonSettings']['pagination']['pageSize']],
        ]);

        return [
            'dataProvider' => $dataProvider,
        ];
    }
}