<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250221192939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create company table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('company_company');
        $table->addColumn('registration_number', 'string', ['length' => 9]);
        $table->addColumn('name', 'string', ['length' => 45]);
        $table->setPrimaryKey(['registration_number']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('company_company');
    }
}
