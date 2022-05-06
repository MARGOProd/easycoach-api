<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220429152010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercice_realise ADD seance_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exercice_realise ADD CONSTRAINT FK_E877AF337F1C8D54 FOREIGN KEY (seance_user_id) REFERENCES seance_user (id)');
        $this->addSql('CREATE INDEX IDX_E877AF337F1C8D54 ON exercice_realise (seance_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercice_realise DROP FOREIGN KEY FK_E877AF337F1C8D54');
        $this->addSql('DROP INDEX IDX_E877AF337F1C8D54 ON exercice_realise');
        $this->addSql('ALTER TABLE exercice_realise DROP seance_user_id');
    }
}
