<?php

class IndexAuthorAction implements IControllerAction
{
    public function execute(?int $id = null): array
    {
        $search = isset($_GET['search_last_name']) ? trim($_GET['search_last_name']) : '';
        $addCriteria = [];
        if ($search !== '') {
            $criteria = new CDbCriteria();
            $criteria->addSearchCondition('last_name', $search, true);
            $addCriteria = [
                'criteria' => $criteria,
                'pagination' => ['pageSize' => Yii::app()->params['commonSettings']['pagination']['pageSize']],
            ];
        }
        $dataProvider = new CActiveDataProvider('Author', $addCriteria);

        return [
            'dataProvider' => $dataProvider,
            'search' => $search,
        ];
    }
}
