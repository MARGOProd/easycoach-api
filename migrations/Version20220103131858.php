<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220103131858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire_muscle (id INT AUTO_INCREMENT NOT NULL, commentaire_id INT NOT NULL, muscle_id INT NOT NULL, INDEX IDX_E795C968BA9CD190 (commentaire_id), INDEX IDX_E795C968354FDBB4 (muscle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire_muscle ADD CONSTRAINT FK_E795C968BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id)');
        $this->addSql('ALTER TABLE commentaire_muscle ADD CONSTRAINT FK_E795C968354FDBB4 FOREIGN KEY (muscle_id) REFERENCES muscle (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commentaire_muscle');
    }
}
