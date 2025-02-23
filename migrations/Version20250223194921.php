<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250223194921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create contract table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('contract_contract');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('company_id', 'string');
        $table->addColumn('customer_id', 'integer');
        $table->addColumn('begin_date', 'date');
        $table->addColumn('end_date', 'date');
        $table->addColumn('name', 'string', ['length' => 100]);
        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('company_company', ['company_id'], ['registration_number']);
        $table->addForeignKeyConstraint('customer_customer', ['customer_id'], ['id']);
        $table->addUniqueIndex(['company_id', 'name']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('contract_contract');
    }
}
