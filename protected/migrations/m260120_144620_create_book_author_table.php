<?php

class m260120_144620_create_book_author_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('book_author', array(
			'book_id' => 'integer NOT NULL',
			'author_id' => 'integer NOT NULL',
		));

		$this->addPrimaryKey('pk_book_author', 'book_author', 'book_id,author_id');
		$this->createIndex('idx_book_author_book', 'book_author', 'book_id');
		$this->createIndex('idx_book_author_author', 'book_author', 'author_id');

		$this->addForeignKey('fk_book_author_book', 'book_author', 'book_id', 'book', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('fk_book_author_author', 'book_author', 'author_id', 'author', 'id', 'CASCADE', 'CASCADE');
		return true;
	}

	public function down()
	{
		$this->dropForeignKey('fk_book_author_book', 'book_author');
		$this->dropForeignKey('fk_book_author_author', 'book_author');
		$this->dropTable('book_author');
		return true;
	}
}

