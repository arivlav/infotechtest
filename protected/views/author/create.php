<?php
/** @var AuthorController $this */
/** @var Author $model */
$this->breadcrumbs = [
        'Authors' => ['index'],
        'Create',
];

?>

<h1>Create Author</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>

