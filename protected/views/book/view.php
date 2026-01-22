<?php
/* @var $this BookController */
/* @var $model Book */
?>

<h1>View Book #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', [
        'data' => $model,
        'attributes' => [
                'id',
                'title',
                'year',
                'description',
                'isbn',
                [
                        'name' => 'image_url',
                        'type' => 'raw',
                        'value' => function($data) {
                            return CHtml::image($data->image_url, CHtml::encode($data->title), ["style"=>"max-height:200px"]);
                        }
                ],
                [
                        'label' => 'Authors',
                        'type' => 'raw',
                        'value' => $model->getAuthorsList(),
                ]
        ]
]); ?>

