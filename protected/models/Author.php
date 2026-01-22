<?php

/**
 * This is the model class for table "author".
 *
 * The followings are the available columns in table 'author':
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string $middle_name
 *
 * The followings are the available model relations:
 * @property Book[] $books
 */
class Author extends CActiveRecord
{
    public $id = null;
    public ?string $last_name = null;
    public ?string $first_name = null;
    public ?string $middle_name = null;

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName(): string
    {
        return 'author';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(): array
    {
        return [
            ['last_name, first_name', 'required'],
            ['last_name, first_name, middle_name', 'length', 'max' => 255],
            ['id, last_name, first_name, middle_name', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations(): array
    {
        return [
            'books' => [self::MANY_MANY, 'Book', 'book_author(author_id,book_id)'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name'
        ];
    }
}

