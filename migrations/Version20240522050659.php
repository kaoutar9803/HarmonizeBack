<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240522050659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscriptions (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, programmes_id INT NOT NULL, date_inscription VARCHAR(255) DEFAULT NULL, INDEX IDX_74E0281CA76ED395 (user_id), INDEX IDX_74E0281CA0A1C920 (programmes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programmes (id INT AUTO_INCREMENT NOT NULL, nom_programme VARCHAR(255) DEFAULT NULL, type_programme VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281CA0A1C920 FOREIGN KEY (programmes_id) REFERENCES programmes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281CA76ED395');
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281CA0A1C920');
        $this->addSql('DROP TABLE inscriptions');
        $this->addSql('DROP TABLE programmes');
    }
}
