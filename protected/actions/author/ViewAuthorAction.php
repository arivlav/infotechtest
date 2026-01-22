<?php

class ViewAuthorAction implements IControllerAction
{
    public function execute(?int $id = null): array
    {
        return [
            'model' => AuthorService::loadModel($id)
        ];
    }
}
