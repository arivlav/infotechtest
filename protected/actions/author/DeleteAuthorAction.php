<?php

class DeleteAuthorAction implements IControllerDeleteAction
{
    public function execute(int $id): void
    {
        AuthorService::loadModel($id)->delete();
    }
}
