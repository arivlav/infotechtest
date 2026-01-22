<?php
/* @var $this BookController */
/* @var $dataProvider CActiveDataProvider */
/* @var $subscriptionModel Subscription */
/* @var $authorsList array */
?>

<h1>Books</h1>

<div id="subscription-message" style="display: none;"></div>

<p>
    <?php echo CHtml::link('Create Book', ['create']); ?>
</p>

<!-- Search Form -->
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'search-form',
        'method' => 'get',
        'action' => ['book/index'],
    ]); ?>

    <h3>Поиск</h3>

    <div class="row">
        <?php echo $form->labelEx(new Book(), 'title'); ?>
        <?php echo $form->textField(new Book(), 'title', [
            'name' => 'search_title',
            'value' => isset($_GET['search_title']) ? $_GET['search_title'] : '',
        ]); ?>
    </div>

    <div class="row">
        <label>Автор</label>
        <?php echo CHtml::textField('search_author', isset($_GET['search_author']) ? $_GET['search_author'] : ''); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx(new Book(), 'year'); ?>
        <?php echo $form->textField(new Book(), 'year', [
            'name' => 'search_year',
            'value' => isset($_GET['search_year']) ? $_GET['search_year'] : '',
        ]); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx(new Book(), 'isbn'); ?>
        <?php echo $form->textField(new Book(), 'isbn', [
            'name' => 'search_isbn',
            'value' => isset($_GET['search_isbn']) ? $_GET['search_isbn'] : '',
        ]); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Поиск'); ?>
        <?php echo CHtml::link('Сбросить', ['book/index']); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', [
        'id' => 'book-grid',
        'dataProvider' => $dataProvider,
        'columns' => [
                'id',
                'title',
                'year',
                [
                        'name' => 'description',
                        'value' => '$data->description',
                ],
                'isbn',
                [
                        'header' => 'Image',
                        'type' => 'html',
                        'value' => function($data) {
                            return CHtml::image($data->image_url, CHtml::encode($data->title), ["style"=>"max-height:80px"]);
                        }
                ],
                [
                        'header' => 'Authors',
                        'value' => '$data->getAuthorsList()'
                ],
                [
                        'class' => 'CButtonColumn',
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                                'update' => ['visible' => '!Yii::app()->user->isGuest'],
                                'delete' => ['visible' => '!Yii::app()->user->isGuest']
                        ]
                ]
        ]
]); ?>

<!-- Subscription Form -->
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'subscription-form',
        'method' => 'post',
        'action' => ['subscribe/subscribe'],
        'enableAjaxValidation' => false,
        'htmlOptions' => [
            'onsubmit' => 'return false;',
        ],
    ]); ?>

    <h3>Подписка</h3>

    <p class="note">Поля с <span class="required">*</span> обязательны для заполнения.</p>

    <div id="subscription-error-summary" style="display: none;"></div>

    <div class="row">
        <?php echo $form->labelEx($subscriptionModel, 'full_name'); ?>
        <?php echo $form->textField($subscriptionModel, 'full_name', ['size' => 60, 'maxlength' => 255, 'id' => 'Subscription_full_name']); ?>
        <div id="Subscription_full_name_em_" style="display: none;" class="errorMessage"></div>
    </div>

    <div class="row">
        <?php echo $form->labelEx($subscriptionModel, 'phone'); ?>
        <?php echo $form->textField($subscriptionModel, 'phone', ['size' => 20, 'maxlength' => 50, 'id' => 'Subscription_phone']); ?>
        <div id="Subscription_phone_em_" style="display: none;" class="errorMessage"></div>
    </div>

    <div class="row">
        <?php echo $form->labelEx($subscriptionModel, 'author_id'); ?>
        <?php echo $form->dropDownList($subscriptionModel, 'author_id', $authorsList, [
            'prompt' => 'Выберите автора',
            'id' => 'Subscription_author_id',
        ]); ?>
        <div id="Subscription_author_id_em_" style="display: none;" class="errorMessage"></div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Подписаться', ['id' => 'subscription-submit']); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
jQuery(function($) {
    $('#subscription-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitBtn = $('#subscription-submit');
        var messageDiv = $('#subscription-message');
        var errorSummary = $('#subscription-error-summary');
        
        // Hide previous messages
        messageDiv.hide().removeClass('flash-success flash-error');
        errorSummary.hide().html('');
        
        // Clear previous errors
        $('.errorMessage').hide().html('');
        $('.error').removeClass('error');
        
        // Disable submit button
        submitBtn.prop('disabled', true);
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Show success message
                    messageDiv.html(response.message).addClass('flash-success').show();
                    // Reset form
                    form[0].reset();
                    // Scroll to message
                    $('html, body').animate({
                        scrollTop: messageDiv.offset().top - 100
                    }, 500);
                } else {
                    // Show error message
                    messageDiv.html(response.message).addClass('flash-error').show();
                    
                    // Show field errors
                    if (response.errors) {
                        $.each(response.errors, function(attribute, errors) {
                            var field = $('#Subscription_' + attribute);
                            var errorDiv = $('#Subscription_' + attribute + '_em_');
                            if (field.length && errors && errors.length > 0) {
                                field.addClass('error');
                                errorDiv.html(errors[0]).show();
                            }
                        });
                        
                        // Show error summary
                        if (Object.keys(response.errors).length > 0) {
                            var errorHtml = '<p class="note">Ошибки при заполнении формы:</p><ul>';
                            $.each(response.errors, function(attribute, errors) {
                                $.each(errors, function(i, error) {
                                    errorHtml += '<li>' + error + '</li>';
                                });
                            });
                            errorHtml += '</ul>';
                            errorSummary.html(errorHtml).show();
                        }
                    }
                }
            },
            error: function() {
                messageDiv.html('Произошла ошибка при отправке формы. Пожалуйста, попробуйте позже.').addClass('flash-error').show();
            },
            complete: function() {
                submitBtn.prop('disabled', false);
            }
        });
        
        return false;
    });
});
</script>
