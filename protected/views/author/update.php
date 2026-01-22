<?php
/** @var AuthorController $this */
/** @var Author $model */
$this->breadcrumbs = [
        'Authors' => ['index'],
        'Update',
];

?>

<h1>Update Author <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>

