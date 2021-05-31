<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210530163739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comentario (id INT AUTO_INCREMENT NOT NULL, discusion_id INT NOT NULL, autor_id INT NOT NULL, texto LONGTEXT NOT NULL, fecha DATE NOT NULL, INDEX IDX_4B91E7024CD8CD01 (discusion_id), INDEX IDX_4B91E70214D45BBE (autor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discusion (id INT AUTO_INCREMENT NOT NULL, creador_id INT NOT NULL, titulo VARCHAR(255) NOT NULL, texto LONGTEXT NOT NULL, INDEX IDX_3C13638162F40C3D (creador_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE juego (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, estado VARCHAR(255) NOT NULL, id_juego VARCHAR(255) NOT NULL, INDEX IDX_F0EC403DDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mensaje (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telefono INT NOT NULL, asunto VARCHAR(255) NOT NULL, texto LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE noticia (id INT AUTO_INCREMENT NOT NULL, titular VARCHAR(255) NOT NULL, imagen VARCHAR(255) NOT NULL, resumen LONGTEXT NOT NULL, contenido LONGTEXT NOT NULL, fecha DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nombre_usuario VARCHAR(255) NOT NULL, fecha_nacimiento DATETIME NOT NULL, foto_perfil VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_2265B05DE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E7024CD8CD01 FOREIGN KEY (discusion_id) REFERENCES discusion (id)');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E70214D45BBE FOREIGN KEY (autor_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE discusion ADD CONSTRAINT FK_3C13638162F40C3D FOREIGN KEY (creador_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE juego ADD CONSTRAINT FK_F0EC403DDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E7024CD8CD01');
        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E70214D45BBE');
        $this->addSql('ALTER TABLE discusion DROP FOREIGN KEY FK_3C13638162F40C3D');
        $this->addSql('ALTER TABLE juego DROP FOREIGN KEY FK_F0EC403DDB38439E');
        $this->addSql('DROP TABLE comentario');
        $this->addSql('DROP TABLE discusion');
        $this->addSql('DROP TABLE juego');
        $this->addSql('DROP TABLE mensaje');
        $this->addSql('DROP TABLE noticia');
        $this->addSql('DROP TABLE usuario');
    }
}
