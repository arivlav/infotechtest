<?php
/** @var AuthorController $this */
/** @var Author $model */
$this->breadcrumbs = [
        'Authors' => ['index'],
        $model->id,
];

?>

<h1>View Author #<?php echo $model->id; ?></h1>

<p>
    <?php echo CHtml::link('List Authors', ['index']); ?> |
    <?php echo CHtml::link('Create Author', ['create']); ?> |
    <?php echo CHtml::link('Update Author', ['update', 'id' => $model->id]); ?> |
    <?php echo CHtml::linkButton('Delete Author', [
            'submit' => ['delete', 'id' => $model->id],
            'confirm' => "Are you sure?",
    ]); ?>
</p>

<?php $this->widget('zii.widgets.CDetailView', [
        'data' => $model,
        'attributes' => [
                'id',
                'last_name',
                'first_name',
                'middle_name',
        ]
]); ?>

<hr/>
