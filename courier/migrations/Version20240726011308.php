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
            numero_documento VARCHAR(50) NOT NULL,
            tipo_documento VARCHAR(50) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id_identificacion)
        )');

        $this->addSql('CREATE TABLE documento (
            id_documento INT NOT NULL AUTO_INCREMENT,
            id_gestor_documento VARCHAR(100) NOT NULL UNIQUE,
            url_ver_documento VARCHAR(250) NOT NULL,
            ruta TEXT DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id_documento)
        )');

        $this->addSql('CREATE TABLE radicado (
            id_radicado INT NOT NULL AUTO_INCREMENT,
            fk_identificacion INT DEFAULT NULL,
            fk_documento INT DEFAULT NULL,
            num_radicado VARCHAR(20) NOT NULL UNIQUE,
            celular VARCHAR(50) DEFAULT NULL,
            cod_dane VARCHAR(5) NOT NULL,
            direccion VARCHAR(100) NOT NULL,
            guia_impresa VARCHAR(50) DEFAULT NULL,
            nombre_completo VARCHAR(200) NOT NULL,
            telefono VARCHAR(50) DEFAULT NULL,
            prioridad VARCHAR(50) NOT NULL,
            impreso BOOLEAN NOT NULL,
            porte_pago BOOLEAN NOT NULL,
            tipo_porte_pago INT NOT NULL,
            tipo_proceso INT NOT NULL,
            tramite VARCHAR(100) DEFAULT NULL,
            subtramite VARCHAR(200) DEFAULT NULL,
            asunto VARCHAR(250) NOT NULL,
            tipo_envio INT NOT NULL,
            serie VARCHAR(250) DEFAULT NULL,
            subserie VARCHAR(250) DEFAULT NULL,
            input_system VARCHAR(250) DEFAULT NULL,
            application_id VARCHAR(250) DEFAULT NULL,
            transaction_id VARCHAR(250) DEFAULT NULL,
            id_case VARCHAR(250) DEFAULT NULL,
            evento_invocado VARCHAR(250) DEFAULT NULL,
            nombre_proceso VARCHAR(250) DEFAULT NULL,
            trace VARCHAR(20) DEFAULT NULL,
            codigo_guia VARCHAR(50) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id_radicado),
            FOREIGN KEY (fk_identificacion) REFERENCES identificacion(id_identificacion),
            FOREIGN KEY (fk_documento) REFERENCES documento(id_documento)
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE radicado');
        $this->addSql('DROP TABLE documento');
        $this->addSql('DROP TABLE identificacion');
    }
}
