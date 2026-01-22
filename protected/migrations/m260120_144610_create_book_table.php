<?php

class m260120_144610_create_book_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('book', array(
			'id' => 'pk',
			'title' => 'string NOT NULL',
			'year' => 'integer',
			'description' => 'text',
			'isbn' => 'string',
			'image_url' => 'string',
		));
		return true;
	}

	public function down()
	{
		$this->dropTable('book');
		return true;
	}
}

