<?php

/**
 * This is the model class for table "book".
 *
 * The followings are the available columns in table 'book':
 * @property integer $id
 * @property string $title
 * @property integer $year
 * @property string $description
 * @property string $isbn
 * @property string $image_url
 *
 * The followings are the available model relations:
 * @property Author[] $authors
 */
class Book extends CActiveRecord
{
    public $id = null;
    public ?string $title = null;
    public ?int $year = null;
    public ?string $description = null;
    public ?string $isbn = null;
    public ?string $image_url = null;
    // Virtual attribute for uploaded file
    public $imageFile = null;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'book';
    }

    public function rules()
    {
        return [
            ['title', 'required'],
            ['year', 'numerical', 'integerOnly' => true],
            ['title, isbn, image_url', 'length', 'max' => 255],
            ['imageFile', 'file', 'types'=>'jpg,jpeg,png,gif', 'allowEmpty'=>true],
            ['description', 'safe'],
            ['id, title, year, isbn', 'safe', 'on' => 'search']
        ];
    }

    public function relations(): array
    {
        return [
            'authors' => [self::MANY_MANY, 'Author', 'book_author(book_id,author_id)'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'year' => 'Year',
            'description' => 'Description',
            'isbn' => 'ISBN',
            'image_url' => 'Image URL'
        ];
    }

    public function getAuthorsList(): string
    {
        $out = [];
        foreach ($this->authors as $a) {
            $initials = trim((isset($a->first_name) ? mb_substr($a->first_name, 0, 1) . '.' : '') . (isset($a->middle_name) && $a->middle_name ? mb_substr($a->middle_name, 0, 1) . '.' : ''));
            $out[] = trim($a->last_name . ' ' . $initials);
        }
        return implode(', ', $out);
    }
}

