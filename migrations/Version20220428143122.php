<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220428143122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seance ADD seance_categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0E5DC6ADFE FOREIGN KEY (seance_categorie_id) REFERENCES seance_categorie (id)');
        $this->addSql('CREATE INDEX IDX_DF7DFD0E5DC6ADFE ON seance (seance_categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0E5DC6ADFE');
        $this->addSql('DROP INDEX IDX_DF7DFD0E5DC6ADFE ON seance');
        $this->addSql('ALTER TABLE seance DROP seance_categorie_id');
    }
}
