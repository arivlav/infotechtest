<?php

class DeleteBookAction implements IControllerDeleteAction
{
    public function execute(int $id): void
    {
        Yii::app()->db->createCommand()->delete('book_author', 'book_id=:id', array(':id' => $id));
        BookService::loadModel($id)->delete();
    }
}