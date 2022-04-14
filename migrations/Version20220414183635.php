<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414183635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A9334E3797A94');
        $this->addSql('DROP INDEX IDX_AA3A9334E3797A94 ON serie');
        $this->addSql('ALTER TABLE serie DROP seance_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serie ADD seance_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A9334E3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_AA3A9334E3797A94 ON serie (seance_id)');
    }
}
