<?php
/** @var AuthorController $this */
/** @var Author $data */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), ['view', 'id' => $data->id]); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
    <?php echo CHtml::encode($data->last_name); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
    <?php echo CHtml::encode($data->first_name); ?>
    <br/>

    <?php if (!empty($data->middle_name)): ?>
        <b><?php echo CHtml::encode($data->getAttributeLabel('middle_name')); ?>:</b>
        <?php echo CHtml::encode($data->middle_name); ?>
        <br/>
    <?php endif; ?>

</div>

