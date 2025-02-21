<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250221201527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create resource table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('resource_resource');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('company_id', 'string', ['length' => 45]);
        $table->addColumn('first_name', 'string', ['length' => 45]);
        $table->addColumn('last_name', 'string', ['length' => 45]);
        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('company_company', ['company_id'], ['registration_number']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('resource_resource');
    }
}
