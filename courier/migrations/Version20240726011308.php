<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240726011308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create a principals tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE identificacion (
            id_identificacion INT NOT NULL AUTO_INCREMENT,
            documento VARCHAR(50) NOT NULL,
            tipo_documento VARCHAR(50) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id_identificacion)
        )');

        $this->addSql('CREATE TABLE radicado (
            id_radicado INT NOT NULL AUTO_INCREMENT,
            fk_identificacion INT DEFAULT NULL,
            num_radicado VARCHAR(20) NOT NULL UNIQUE,
            celular VARCHAR(50) DEFAULT NULL,
            cod_dane VARCHAR(5) NOT NULL,
            direccion VARCHAR(100) NOT NULL,
            guia_impresa VARCHAR(50) NOT NULL,
            nombre_completo VARCHAR(200) NOT NULL,
            telefono VARCHAR(50) DEFAULT NULL,
            prioridad VARCHAR(50) NOT NULL,
            impreso VARCHAR(50) NOT NULL,
            porte_pago VARCHAR(50) NOT NULL,
            tipo_porte_pago VARCHAR(50) NOT NULL,
            tipo_proceso VARCHAR(50) NOT NULL,
            radicado_caso_padre VARCHAR(20) DEFAULT NULL,
            usuario_solicitante VARCHAR(200) DEFAULT NULL,
            codigo_guia VARCHAR(50) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id_radicado),
            FOREIGN KEY (fk_identificacion) REFERENCES identificacion(id_identificacion)
        )');

        $this->addSql('CREATE TABLE documento (
            id_documento INT NOT NULL AUTO_INCREMENT,
            fk_radicado INT NOT NULL,
            id_gestor_documento VARCHAR(100) NOT NULL UNIQUE,
            end_point_file_net VARCHAR(250) NOT NULL,
            orden_imp INT NOT NULL,
            num_paginas INT NOT NULL,
            ruta TEXT DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id_documento),
            FOREIGN KEY (fk_radicado) REFERENCES radicado(id_radicado)
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE documento');
        $this->addSql('DROP TABLE radicado');
        $this->addSql('DROP TABLE identificacion');
    }
}
