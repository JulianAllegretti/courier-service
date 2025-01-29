<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250129043421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove restriction to document duplicated';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE documento DROP INDEX id_gestor_documento;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT UNIQUE (id_gestor_documento);');
    }
}
