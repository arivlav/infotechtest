<?php

class ViewBookAction implements IControllerAction
{
    public function execute(?int $id = null): array
    {
        return [
            'model' => BookService::loadModel($id)
        ];
    }
}