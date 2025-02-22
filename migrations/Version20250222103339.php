<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250222103339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create work_schedule table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('availability_work_schedule');
        $table->addColumn('resource_id', 'integer');
        $table->addColumn('configuration', 'json');
        $table->addForeignKeyConstraint('resource_resource', ['resource_id'], ['id']);
        $table->setPrimaryKey(['resource_id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('availability_work_schedule');
    }
}
