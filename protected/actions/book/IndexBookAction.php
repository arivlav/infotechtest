<?php

class IndexBookAction implements IControllerAction
{
    public function execute(?int $id = null): array
    {
        $subscriptionModel = new Subscription();
        $authorsList = BookService::buildAuthorsList();

        $dataProvider = new CActiveDataProvider('Book', [
            'criteria' => $this->getSearchCriteria(),
            'pagination' => ['pageSize' => Yii::app()->params['commonSettings']['pagination']['pageSize']],
        ]);

        return [
            'dataProvider' => $dataProvider,
            'subscriptionModel' => $subscriptionModel,
            'authorsList' => $authorsList,
        ];
    }

    private function getSearchCriteria(): CDbCriteria
    {
        $criteria = new CDbCriteria();
        $criteria->with = ['authors'];

        if (!empty($_GET['search_title'])) {
            $criteria->addSearchCondition('title', $_GET['search_title'], true);
        }

        if (!empty($_GET['search_isbn'])) {
            $criteria->addSearchCondition('isbn', $_GET['search_isbn'], true);
        }

        if (!empty($_GET['search_year'])) {
            $criteria->compare('year', $_GET['search_year']);
        }
        
        if (!empty($_GET['search_author'])) {
            $criteria->with['authors'] = [
                'together' => true,
                'condition' => 'authors.last_name LIKE :author OR authors.first_name LIKE :author OR authors.middle_name LIKE :author',
                'params' => [':author' => '%' . $_GET['search_author'] . '%'],
            ];
        }
        
        return $criteria;
    }
}