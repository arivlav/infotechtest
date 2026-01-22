<?php

class m260122_000001_add_author_id_to_subscribe extends CDbMigration
{
	public function up(): bool
	{
		$this->addColumn('subscription', 'author_id', 'integer NOT NULL');
		$this->createIndex('idx_subscription_author_id', 'subscription', 'author_id');
		$this->addForeignKey('fk_subscription_author', 'subscription', 'author_id', 'author', 'id', 'CASCADE', 'CASCADE');
		return true;
	}

	public function down(): bool
	{
		$this->dropForeignKey('fk_subscription_author', 'subscription');
		$this->dropIndex('idx_subscription_author_id', 'subscription');
		$this->dropColumn('subscription', 'author_id');
		return true;
	}
}
