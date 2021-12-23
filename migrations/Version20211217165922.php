<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211217165922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercice_realise (id INT AUTO_INCREMENT NOT NULL, quantite INT NOT NULL, occurrence INT NOT NULL, poids NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE frequence (id INT AUTO_INCREMENT NOT NULL, type INT NOT NULL, sets INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seance (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, debut DATETIME NOT NULL, libelle VARCHAR(255) DEFAULT NULL, INDEX IDX_DF7DFD0E19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serie (id INT AUTO_INCREMENT NOT NULL, seance_id INT DEFAULT NULL, frequence_id INT NOT NULL, type INT NOT NULL, INDEX IDX_AA3A9334E3797A94 (seance_id), UNIQUE INDEX UNIQ_AA3A93348E487805 (frequence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serie_exercice (id INT AUTO_INCREMENT NOT NULL, serie_id INT NOT NULL, exercice_id INT NOT NULL, repetition INT NOT NULL, poids NUMERIC(10, 2) DEFAULT NULL, calorie INT DEFAULT NULL, duree TIME DEFAULT NULL, INDEX IDX_AC9E6875D94388BD (serie_id), INDEX IDX_AC9E687589D40298 (exercice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0E19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A9334E3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id)');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A93348E487805 FOREIGN KEY (frequence_id) REFERENCES frequence (id)');
        $this->addSql('ALTER TABLE serie_exercice ADD CONSTRAINT FK_AC9E6875D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('ALTER TABLE serie_exercice ADD CONSTRAINT FK_AC9E687589D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A93348E487805');
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A9334E3797A94');
        $this->addSql('ALTER TABLE serie_exercice DROP FOREIGN KEY FK_AC9E6875D94388BD');
        $this->addSql('DROP TABLE exercice_realise');
        $this->addSql('DROP TABLE frequence');
        $this->addSql('DROP TABLE seance');
        $this->addSql('DROP TABLE serie');
        $this->addSql('DROP TABLE serie_exercice');
    }
}
