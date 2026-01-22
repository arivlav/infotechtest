<?php

class AuthorService
{
    /**
     * Load Author model by primary key or throw 404.
     *
     * @param int|string $id
     * @return Author
     * @throws CHttpException
     */
    public static function loadModel($id): Author
    {
        $model = Author::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested author does not exist.');
        }
        return $model;
    }
}
