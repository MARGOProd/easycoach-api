<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220103080019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, seance_id INT DEFAULT NULL, serie_id INT DEFAULT NULL, exercice_realise_id INT DEFAULT NULL, content LONGTEXT NOT NULL, INDEX IDX_67F068BC19EB6921 (client_id), INDEX IDX_67F068BCE3797A94 (seance_id), INDEX IDX_67F068BCD94388BD (serie_id), INDEX IDX_67F068BCA792DAA8 (exercice_realise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCE3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCD94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA792DAA8 FOREIGN KEY (exercice_realise_id) REFERENCES exercice_realise (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commentaire');
    }
}
