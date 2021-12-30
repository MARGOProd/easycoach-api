<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211229135630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercice_realise ADD materiel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exercice_realise ADD CONSTRAINT FK_E877AF3316880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id)');
        $this->addSql('CREATE INDEX IDX_E877AF3316880AAF ON exercice_realise (materiel_id)');
        $this->addSql('ALTER TABLE serie_exercice ADD materiel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE serie_exercice ADD CONSTRAINT FK_AC9E687516880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id)');
        $this->addSql('CREATE INDEX IDX_AC9E687516880AAF ON serie_exercice (materiel_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercice_realise DROP FOREIGN KEY FK_E877AF3316880AAF');
        $this->addSql('DROP INDEX IDX_E877AF3316880AAF ON exercice_realise');
        $this->addSql('ALTER TABLE exercice_realise DROP materiel_id');
        $this->addSql('ALTER TABLE serie_exercice DROP FOREIGN KEY FK_AC9E687516880AAF');
        $this->addSql('DROP INDEX IDX_AC9E687516880AAF ON serie_exercice');
        $this->addSql('ALTER TABLE serie_exercice DROP materiel_id');
    }
}
