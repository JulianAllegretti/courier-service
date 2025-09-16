<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Add Full-Text indexes for optimized search performance
 */
final class Version20250130000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Full-Text indexes for optimized search performance';
    }

    public function up(Schema $schema): void
    {
        // Índice FULLTEXT para num_radicado
        $this->addSql('CREATE FULLTEXT INDEX ft_radicado_num_radicado ON radicado (num_radicado)');
        
        // Índice FULLTEXT para nombre_completo
        $this->addSql('CREATE FULLTEXT INDEX ft_radicado_nombre ON radicado (nombre_completo)');
        
        // Índice FULLTEXT para telefono
        $this->addSql('CREATE FULLTEXT INDEX ft_radicado_telefono ON radicado (telefono)');
        
        // Índice FULLTEXT para radicado_caso_padre
        $this->addSql('CREATE FULLTEXT INDEX ft_radicado_padre ON radicado (radicado_caso_padre)');
        
        // Índice FULLTEXT para codigo_guia
        $this->addSql('CREATE FULLTEXT INDEX ft_radicado_guia ON radicado (codigo_guia)');
        
        // Índice FULLTEXT compuesto para búsquedas generales
        $this->addSql('CREATE FULLTEXT INDEX ft_radicado_general ON radicado (num_radicado, nombre_completo, telefono, radicado_caso_padre, codigo_guia)');
        
        // Índices BTREE para ordenamiento y filtros exactos
        $this->addSql('CREATE INDEX idx_radicado_created_at ON radicado (created_at)');
        $this->addSql('CREATE INDEX idx_radicado_id_desc ON radicado (id_radicado DESC)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX ft_radicado_num_radicado ON radicado');
        $this->addSql('DROP INDEX ft_radicado_nombre ON radicado');
        $this->addSql('DROP INDEX ft_radicado_telefono ON radicado');
        $this->addSql('DROP INDEX ft_radicado_padre ON radicado');
        $this->addSql('DROP INDEX ft_radicado_guia ON radicado');
        $this->addSql('DROP INDEX ft_radicado_general ON radicado');
        $this->addSql('DROP INDEX idx_radicado_created_at ON radicado');
        $this->addSql('DROP INDEX idx_radicado_id_desc ON radicado');
    }
}