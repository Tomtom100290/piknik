<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251124114539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, pseudo VARCHAR(25) NOT NULL, date_creat DATETIME NOT NULL, fk_arrondissement_id INT DEFAULT NULL, INDEX IDX_8D93D6498E4A32E9 (fk_arrondissement_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498E4A32E9 FOREIGN KEY (fk_arrondissement_id) REFERENCES arrondissement (id)');
        $this->addSql('ALTER TABLE avis ADD fk_lieu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF09A9D2EE0 FOREIGN KEY (fk_lieu_id) REFERENCES lieu (id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF09A9D2EE0 ON avis (fk_lieu_id)');
        $this->addSql('ALTER TABLE favoris ADD fk_lieu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4329A9D2EE0 FOREIGN KEY (fk_lieu_id) REFERENCES lieu (id)');
        $this->addSql('CREATE INDEX IDX_8933C4329A9D2EE0 ON favoris (fk_lieu_id)');
        $this->addSql('ALTER TABLE image ADD lieu_fk_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F6047BECB FOREIGN KEY (lieu_fk_id) REFERENCES lieu (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F6047BECB ON image (lieu_fk_id)');
        $this->addSql('ALTER TABLE lieu ADD categorie_fk_id INT DEFAULT NULL, ADD arrondissement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lieu ADD CONSTRAINT FK_2F577D59500FF400 FOREIGN KEY (categorie_fk_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE lieu ADD CONSTRAINT FK_2F577D59407DBC11 FOREIGN KEY (arrondissement_id) REFERENCES commune (id)');
        $this->addSql('CREATE INDEX IDX_2F577D59500FF400 ON lieu (categorie_fk_id)');
        $this->addSql('CREATE INDEX IDX_2F577D59407DBC11 ON lieu (arrondissement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498E4A32E9');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF09A9D2EE0');
        $this->addSql('DROP INDEX IDX_8F91ABF09A9D2EE0 ON avis');
        $this->addSql('ALTER TABLE avis DROP fk_lieu_id');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4329A9D2EE0');
        $this->addSql('DROP INDEX IDX_8933C4329A9D2EE0 ON favoris');
        $this->addSql('ALTER TABLE favoris DROP fk_lieu_id');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F6047BECB');
        $this->addSql('DROP INDEX IDX_C53D045F6047BECB ON image');
        $this->addSql('ALTER TABLE image DROP lieu_fk_id');
        $this->addSql('ALTER TABLE lieu DROP FOREIGN KEY FK_2F577D59500FF400');
        $this->addSql('ALTER TABLE lieu DROP FOREIGN KEY FK_2F577D59407DBC11');
        $this->addSql('DROP INDEX IDX_2F577D59500FF400 ON lieu');
        $this->addSql('DROP INDEX IDX_2F577D59407DBC11 ON lieu');
        $this->addSql('ALTER TABLE lieu DROP categorie_fk_id, DROP arrondissement_id');
    }
}
