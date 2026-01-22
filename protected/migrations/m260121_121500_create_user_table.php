<?php

class m260121_121500_create_user_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('user', array(
			'id' => 'pk',
			'username' => 'string NOT NULL',
			'password' => 'string NOT NULL',
			'email' => 'string',
			'created_at' => 'datetime',
		));

		$this->createIndex('idx_user_username', 'user', 'username', true);

		// seed admin user with password 'admin123'
		if(function_exists('password_hash')){
			$hash = password_hash('admin123', PASSWORD_DEFAULT);
		} else {
			$hash = md5('admin123');
		}
		$this->insert('user', array(
			'username' => 'admin',
			'password' => $hash,
			'email' => 'admin@example.com',
			'created_at' => new CDbExpression('NOW()'),
		));
		return true;
	}

	public function down()
	{
		$this->delete('user', 'username=:u', array(':u' => 'admin'));
		$this->dropIndex('idx_user_username', 'user');
		$this->dropTable('user');
		return true;
	}
}

