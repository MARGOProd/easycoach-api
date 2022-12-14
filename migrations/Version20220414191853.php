<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414191853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE seance_marque (id INT AUTO_INCREMENT NOT NULL, seance_id INT DEFAULT NULL, marque_id INT DEFAULT NULL, INDEX IDX_251A8A66E3797A94 (seance_id), INDEX IDX_251A8A664827B9B2 (marque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE seance_marque ADD CONSTRAINT FK_251A8A66E3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id)');
        $this->addSql('ALTER TABLE seance_marque ADD CONSTRAINT FK_251A8A664827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0E4827B9B2');
        $this->addSql('DROP INDEX IDX_DF7DFD0E4827B9B2 ON seance');
        $this->addSql('ALTER TABLE seance DROP marque_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE seance_marque');
        $this->addSql('ALTER TABLE seance ADD marque_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0E4827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_DF7DFD0E4827B9B2 ON seance (marque_id)');
    }
}
