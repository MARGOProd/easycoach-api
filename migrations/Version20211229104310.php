<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211229104310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercice_muscle (id INT AUTO_INCREMENT NOT NULL, exercice_id INT NOT NULL, muscle_id INT NOT NULL, is_direct TINYINT(1) NOT NULL, INDEX IDX_2A9ECEF589D40298 (exercice_id), INDEX IDX_2A9ECEF5354FDBB4 (muscle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_musculaire (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE muscle (id INT AUTO_INCREMENT NOT NULL, groupe_musculaire_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_F31119EF1287564D (groupe_musculaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercice_muscle ADD CONSTRAINT FK_2A9ECEF589D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id)');
        $this->addSql('ALTER TABLE exercice_muscle ADD CONSTRAINT FK_2A9ECEF5354FDBB4 FOREIGN KEY (muscle_id) REFERENCES muscle (id)');
        $this->addSql('ALTER TABLE muscle ADD CONSTRAINT FK_F31119EF1287564D FOREIGN KEY (groupe_musculaire_id) REFERENCES groupe_musculaire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE muscle DROP FOREIGN KEY FK_F31119EF1287564D');
        $this->addSql('ALTER TABLE exercice_muscle DROP FOREIGN KEY FK_2A9ECEF5354FDBB4');
        $this->addSql('DROP TABLE exercice_muscle');
        $this->addSql('DROP TABLE groupe_musculaire');
        $this->addSql('DROP TABLE muscle');
    }
}
