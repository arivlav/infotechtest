<?php

/**
 * This is the model class for table "subscribe".
 *
 * The followings are the available columns in table 'subscribe':
 * @property integer $id
 * @property string $full_name
 * @property string $phone
 * @property integer $author_id
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property Author $author
 */
class Subscription extends CActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName(): string
	{
		return 'subscription';
	}

	public function rules(): array
	{
		return array(
			array('full_name, phone, author_id', 'required'),
			array('author_id', 'numerical', 'integerOnly' => true),
			array('full_name', 'length', 'max' => 255),
			array('phone', 'length', 'max' => 50),
			array('phone', 'match', 'pattern' => '/^[\d\s\-\+\(\)]+$/', 'message' => 'Phone number can only contain digits, spaces, and characters: - + ( )'),
			array('author_id', 'exist', 'className' => 'Author', 'attributeName' => 'id'),
			array('id, full_name, phone, author_id, created_at', 'safe', 'on' => 'search'),
		);
	}

	public function relations(): array
	{
		return array(
			'author' => array(self::BELONGS_TO, 'Author', 'author_id'),
		);
	}

	public function attributeLabels(): array
	{
		return array(
			'id' => 'ID',
			'full_name' => 'ФИО',
			'phone' => 'Номер телефона',
			'author_id' => 'Автор',
			'created_at' => 'Дата создания',
		);
	}

	public function beforeSave(): bool
	{
		if ($this->isNewRecord) {
			$this->created_at = new CDbExpression('NOW()');
		}
		return parent::beforeSave();
	}
}
