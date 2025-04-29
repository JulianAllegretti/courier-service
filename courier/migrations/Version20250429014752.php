<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250429014752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create courier row into cod_dane table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('alter table cod_dane add courier varchar(50) null');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('alter table cod_dane drop column courier');
    }
}
