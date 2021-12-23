<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211222112332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercice_realise ADD serie_id INT NOT NULL, ADD serie_exercice_id INT DEFAULT NULL, ADD exercice_id INT NOT NULL');
        $this->addSql('ALTER TABLE exercice_realise ADD CONSTRAINT FK_E877AF33D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('ALTER TABLE exercice_realise ADD CONSTRAINT FK_E877AF338EE830CB FOREIGN KEY (serie_exercice_id) REFERENCES serie_exercice (id)');
        $this->addSql('ALTER TABLE exercice_realise ADD CONSTRAINT FK_E877AF3389D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id)');
        $this->addSql('CREATE INDEX IDX_E877AF33D94388BD ON exercice_realise (serie_id)');
        $this->addSql('CREATE INDEX IDX_E877AF338EE830CB ON exercice_realise (serie_exercice_id)');
        $this->addSql('CREATE INDEX IDX_E877AF3389D40298 ON exercice_realise (exercice_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercice_realise DROP FOREIGN KEY FK_E877AF33D94388BD');
        $this->addSql('ALTER TABLE exercice_realise DROP FOREIGN KEY FK_E877AF338EE830CB');
        $this->addSql('ALTER TABLE exercice_realise DROP FOREIGN KEY FK_E877AF3389D40298');
        $this->addSql('DROP INDEX IDX_E877AF33D94388BD ON exercice_realise');
        $this->addSql('DROP INDEX IDX_E877AF338EE830CB ON exercice_realise');
        $this->addSql('DROP INDEX IDX_E877AF3389D40298 ON exercice_realise');
        $this->addSql('ALTER TABLE exercice_realise DROP serie_id, DROP serie_exercice_id, DROP exercice_id');
    }
}
