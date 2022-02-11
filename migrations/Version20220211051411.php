<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220211051411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercice_categorie (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_EBB23D22727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercice_categorie ADD CONSTRAINT FK_EBB23D22727ACA70 FOREIGN KEY (parent_id) REFERENCES exercice_categorie (id)');
        $this->addSql('ALTER TABLE exercice ADD exercice_categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exercice ADD CONSTRAINT FK_E418C74D120FCD4B FOREIGN KEY (exercice_categorie_id) REFERENCES exercice_categorie (id)');
        $this->addSql('CREATE INDEX IDX_E418C74D120FCD4B ON exercice (exercice_categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercice DROP FOREIGN KEY FK_E418C74D120FCD4B');
        $this->addSql('ALTER TABLE exercice_categorie DROP FOREIGN KEY FK_EBB23D22727ACA70');
        $this->addSql('DROP TABLE exercice_categorie');
        $this->addSql('DROP INDEX IDX_E418C74D120FCD4B ON exercice');
        $this->addSql('ALTER TABLE exercice DROP exercice_categorie_id');
    }
}
