<?php
/* @var $this BookController */
/* @var $model Book */
/* @var array $authorsList */
/* @var array $selectedAuthors */
?>

<h1>Create Book</h1>

<?php $this->renderPartial('_form', array(
	'model'=>$model,
	'authorsList'=>$authorsList,
	'selectedAuthors'=>$selectedAuthors,
)); ?>

