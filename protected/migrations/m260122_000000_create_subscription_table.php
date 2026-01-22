<?php

class m260122_000000_create_subscription_table extends CDbMigration
{
	public function up(): bool
	{
		$this->createTable('subscribe', array(
			'id' => 'pk',
			'full_name' => 'string NOT NULL',
			'phone' => 'string NOT NULL',
			'author_id' => 'integer NOT NULL',
			'created_at' => 'datetime',
		));

		$this->createIndex('idx_subscribe_phone', 'subscribe', 'phone');
		$this->createIndex('idx_subscribe_author_id', 'subscribe', 'author_id');
		$this->addForeignKey('fk_subscribe_author', 'subscribe', 'author_id', 'author', 'id', 'CASCADE', 'CASCADE');
		return true;
	}

	public function down(): bool
	{
		$this->dropForeignKey('fk_subscribe_author', 'subscribe');
		$this->dropIndex('idx_subscribe_author_id', 'subscribe');
		$this->dropIndex('idx_subscribe_phone', 'subscribe');
		$this->dropTable('subscribe');
		return true;
	}
}
