<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Add FULLTEXT indexes for optimized search performance on documento table
 */
final class Version20250131000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add FULLTEXT indexes for optimized search performance on documento table';
    }

    public function up(Schema $schema): void
    {
        // Índice FULLTEXT para id_gestor_documento (MATCH AGAINST)
        $this->addSql('CREATE FULLTEXT INDEX ft_documento_id_gestor ON documento (id_gestor_documento)');
        
        // Índice FULLTEXT para ruta (MATCH AGAINST)
        $this->addSql('CREATE FULLTEXT INDEX ft_documento_ruta ON documento (ruta)');
        
        // Índice FULLTEXT para end_point_file_net (MATCH AGAINST)
        $this->addSql('CREATE FULLTEXT INDEX ft_documento_endpoint ON documento (end_point_file_net)');
        
        // Índice FULLTEXT compuesto para búsquedas generales
        $this->addSql('CREATE FULLTEXT INDEX ft_documento_general ON documento (id_gestor_documento, ruta, end_point_file_net)');
        
        // Índices BTREE para ordenamiento y filtros exactos
        $this->addSql('CREATE INDEX idx_documento_created_at ON documento (created_at)');
        $this->addSql('CREATE INDEX idx_documento_id_desc ON documento (id_documento DESC)');
        $this->addSql('CREATE INDEX idx_documento_fk_radicado ON documento (fk_radicado)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX ft_documento_id_gestor ON documento');
        $this->addSql('DROP INDEX ft_documento_ruta ON documento');
        $this->addSql('DROP INDEX ft_documento_endpoint ON documento');
        $this->addSql('DROP INDEX ft_documento_general ON documento');
        $this->addSql('DROP INDEX idx_documento_created_at ON documento');
        $this->addSql('DROP INDEX idx_documento_id_desc ON documento');
        $this->addSql('DROP INDEX idx_documento_fk_radicado ON documento');
    }
}
