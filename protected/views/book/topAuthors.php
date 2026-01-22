<?php
/** @var BookController $this */
/** @var array $authors */
/** @var int $year */
?>

<h1>Топ-10 авторов по количеству книг</h1>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'year-form',
        'method' => 'get',
        'action' => ['book/topAuthors'],
    ]); ?>

    <div class="row">
        <label for="year">Год:</label>
        <?php echo CHtml::textField('year', $year, [
            'id' => 'year',
            'style' => 'width: 100px;',
        ]); ?>
        <?php echo CHtml::submitButton('Показать'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

<?php if (empty($authors)): ?>
    <p>За выбранный год не найдено авторов с книгами.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Место</th>
                <th>Автор</th>
                <th>Количество книг</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($authors as $index => $author): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td>
                        <?php echo CHtml::encode($author['full_name']); ?>
                    </td>
                    <td><?php echo $author['book_count']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
