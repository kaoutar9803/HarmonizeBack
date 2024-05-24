<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240522064442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suivi ADD objectifs_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, CHANGE valeur_actuelle valeur_actuelle DOUBLE PRECISION NOT NULL, CHANGE date_suivi date_suivi DATE NOT NULL');
        $this->addSql('ALTER TABLE suivi ADD CONSTRAINT FK_2EBCCA8F66DAD6F2 FOREIGN KEY (objectifs_id) REFERENCES objectifs (id)');
        $this->addSql('ALTER TABLE suivi ADD CONSTRAINT FK_2EBCCA8FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2EBCCA8F66DAD6F2 ON suivi (objectifs_id)');
        $this->addSql('CREATE INDEX IDX_2EBCCA8FA76ED395 ON suivi (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suivi DROP FOREIGN KEY FK_2EBCCA8F66DAD6F2');
        $this->addSql('ALTER TABLE suivi DROP FOREIGN KEY FK_2EBCCA8FA76ED395');
        $this->addSql('DROP INDEX IDX_2EBCCA8F66DAD6F2 ON suivi');
        $this->addSql('DROP INDEX IDX_2EBCCA8FA76ED395 ON suivi');
        $this->addSql('ALTER TABLE suivi DROP objectifs_id, DROP user_id, CHANGE valeur_actuelle valeur_actuelle VARCHAR(255) NOT NULL, CHANGE date_suivi date_suivi VARCHAR(255) NOT NULL');
    }
}
