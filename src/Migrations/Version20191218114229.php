<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191218114229 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE breaks CHANGE date_fin date_fin DATETIME NOT NULL, CHANGE id_utilisateur utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE breaks ADD CONSTRAINT FK_7D048891FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_7D048891FB88E14F ON breaks (utilisateur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE breaks DROP FOREIGN KEY FK_7D048891FB88E14F');
        $this->addSql('DROP INDEX IDX_7D048891FB88E14F ON breaks');
        $this->addSql('ALTER TABLE breaks CHANGE date_fin date_fin DATETIME DEFAULT NULL, CHANGE utilisateur_id id_utilisateur INT NOT NULL');
    }
}
