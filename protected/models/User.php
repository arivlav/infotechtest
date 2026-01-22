<?php

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $created_at
 */
class User extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName(): string
    {
        return 'user';
    }

    public function rules(): array
    {
        return [
            ['username, password', 'required'],
            ['username, password, email', 'length', 'max' => 255],
            ['id, username, email, created_at', 'safe', 'on' => 'search']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'created_at' => 'Created At',
        ];
    }
}

