<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309160434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serie_exercice ADD tempo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE serie_exercice ADD CONSTRAINT FK_AC9E6875234B247D FOREIGN KEY (tempo_id) REFERENCES tempo (id)');
        $this->addSql('CREATE INDEX IDX_AC9E6875234B247D ON serie_exercice (tempo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serie_exercice DROP FOREIGN KEY FK_AC9E6875234B247D');
        $this->addSql('DROP INDEX IDX_AC9E6875234B247D ON serie_exercice');
        $this->addSql('ALTER TABLE serie_exercice DROP tempo_id');
    }
}
