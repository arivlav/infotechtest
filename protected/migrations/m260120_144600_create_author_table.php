<?php

class m260120_144600_create_author_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('author', array(
			'id' => 'pk',
			'last_name' => 'string NOT NULL',
			'first_name' => 'string NOT NULL',
			'middle_name' => 'string',
		));
		return true;
	}

	public function down()
	{
		$this->dropTable('author');
		return true;
	}
}

