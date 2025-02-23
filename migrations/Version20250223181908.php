<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250223181908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create customer table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('customer_customer');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('company_id', 'string');
        $table->addColumn('registration_number', 'string', ['length' => 9]);
        $table->addColumn('name', 'string', ['length' => 45]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['company_id', 'registration_number'], 'company_registration_number_unique_index');
        $table->addForeignKeyConstraint('company_company', ['company_id'], ['registration_number']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('customer_customer');
    }
}
