<?php
/* @var $this BookController */
/* @var $model Book */
/* @var array $authorsList */
/* @var array $selectedAuthors */
?>

<h1>Update Book #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array(
	'model'=>$model,
	'authorsList'=>$authorsList,
	'selectedAuthors'=>$selectedAuthors,
)); ?>

