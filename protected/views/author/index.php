<?php
/** @var AuthorController $this */
/** @var CActiveDataProvider $dataProvider */
$this->breadcrumbs = [
        'Authors',
];

?>

<h1>Authors</h1>

<p>
    <?php echo CHtml::link('Create Author', ['create']); ?>
</p>

<div id="author-search">
    <?php echo CHtml::beginForm('', 'get', ['id' => 'author-search-form']); ?>
    <?php echo CHtml::label('Last name:', 'search_last_name'); ?>
    <?php echo CHtml::textField('search_last_name', isset($search) ? CHtml::encode($search) : '', ['size' => 30]); ?>
    <?php echo CHtml::submitButton('Search'); ?>
    <?php echo CHtml::endForm(); ?>
</div>

<?php $this->widget('zii.widgets.CListView', [
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
]); ?>

