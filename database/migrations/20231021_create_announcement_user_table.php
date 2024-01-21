<?php

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

return new class {
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('announcement_user');
        $table->addColumn('announcement_id', Types::INTEGER, [
            'unsigned' => true,
        ]);
        $table->addColumn('user_id', Types::INTEGER, [
            'unsigned' => true,
        ]);
        $table->addForeignKeyConstraint('announcements', ['announcement_id'], ['id']);
        $table->addForeignKeyConstraint('users', ['user_id'], ['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('announcement_user');
    }
};
