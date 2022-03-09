<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309160031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tempo (id INT AUTO_INCREMENT NOT NULL, descente INT DEFAULT NULL, static INT DEFAULT NULL, montee INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercice_realise DROP tempo');
        $this->addSql('ALTER TABLE serie_exercice DROP tempo');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tempo');
        $this->addSql('ALTER TABLE exercice_realise ADD tempo INT DEFAULT NULL');
        $this->addSql('ALTER TABLE serie_exercice ADD tempo INT DEFAULT NULL');
    }
}
