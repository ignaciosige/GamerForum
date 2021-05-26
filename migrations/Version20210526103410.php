<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210526103410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE juego ADD estado VARCHAR(255) NOT NULL, DROP jugado, DROP jugando, DROP pendiente');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE juego ADD jugado TINYINT(1) NOT NULL, ADD jugando TINYINT(1) NOT NULL, ADD pendiente TINYINT(1) NOT NULL, DROP estado');
    }
}
