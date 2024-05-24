<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240522063522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activites (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, type_activite VARCHAR(255) NOT NULL, duree VARCHAR(255) NOT NULL, calories VARCHAR(255) NOT NULL, date VARCHAR(255) NOT NULL, INDEX IDX_766B5EB5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objectifs (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, type_objectif VARCHAR(255) NOT NULL, valeur_cible VARCHAR(255) NOT NULL, date_debut VARCHAR(255) NOT NULL, date_fin VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_7805601A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suivi (id INT AUTO_INCREMENT NOT NULL, valeur_actuelle VARCHAR(255) NOT NULL, date_suivi VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activites ADD CONSTRAINT FK_766B5EB5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE objectifs ADD CONSTRAINT FK_7805601A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activites DROP FOREIGN KEY FK_766B5EB5A76ED395');
        $this->addSql('ALTER TABLE objectifs DROP FOREIGN KEY FK_7805601A76ED395');
        $this->addSql('DROP TABLE activites');
        $this->addSql('DROP TABLE objectifs');
        $this->addSql('DROP TABLE suivi');
    }
}