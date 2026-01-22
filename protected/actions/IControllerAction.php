<?php

interface IControllerAction
{
    public function execute(?int $id = null): array;
}