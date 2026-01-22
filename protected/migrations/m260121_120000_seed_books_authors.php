<?php

class m260121_120000_seed_books_authors extends CDbMigration
{
	public function up()
	{
		// Insert authors
		$this->insert('author', array(
			'id' => 1,
			'last_name' => 'Ivanov',
			'first_name' => 'Ivan',
			'middle_name' => 'Ivanovich',
		));
		$this->insert('author', array(
			'id' => 2,
			'last_name' => 'Petrov',
			'first_name' => 'Pavel',
			'middle_name' => 'Sergeevich',
		));
		$this->insert('author', array(
			'id' => 3,
			'last_name' => 'Sidorova',
			'first_name' => 'Anna',
			'middle_name' => null,
		));

		// Insert books
		$this->insert('book', array(
			'id' => 1,
			'title' => 'Learning Yii',
			'year' => 2019,
			'description' => 'A practical guide to Yii framework.',
			'isbn' => '978-1-23456-789-0',
			'image_url' => '/images/learning-yii.jpg',
		));
		$this->insert('book', array(
			'id' => 2,
			'title' => 'PHP Patterns',
			'year' => 2018,
			'description' => 'Design patterns and best practices in PHP.',
			'isbn' => '978-0-98765-432-1',
			'image_url' => '/images/php-patterns.jpg',
		));

		// Link books and authors
		$this->insert('book_author', array('book_id' => 1, 'author_id' => 1));
		$this->insert('book_author', array('book_id' => 1, 'author_id' => 2));
		$this->insert('book_author', array('book_id' => 2, 'author_id' => 3));
		return true;
	}

	public function down()
	{
		$this->delete('book_author', 'book_id IN (1,2)');
		$this->delete('book', 'id IN (1,2)');
		$this->delete('author', 'id IN (1,2,3)');
		return true;
	}
}

