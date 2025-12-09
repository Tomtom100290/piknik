<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251201063054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('CREATE TABLE arrondissement (id INT AUTO_INCREMENT NOT NULL, code_postal VARCHAR(5) NOT NULL, localite VARCHAR(50) NOT NULL, date_creat DATETIME NOT NULL, fk_commune_id INT DEFAULT NULL, INDEX IDX_3A3B64C4E37485E1 (fk_commune_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        //$this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, note SMALLINT NOT NULL, commentaire VARCHAR(255) DEFAULT NULL, statut TINYINT(1) NOT NULL, date_creat DATETIME NOT NULL, fk_lieu_id INT DEFAULT NULL, fk_user_id INT DEFAULT NULL, INDEX IDX_8F91ABF09A9D2EE0 (fk_lieu_id), INDEX IDX_8F91ABF05741EEB9 (fk_user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        //$this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, date_creat DATETIME NOT NULL, status_visu VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        //$this->addSql('CREATE TABLE commune (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, code_postal_commune VARCHAR(5) DEFAULT NULL, date_creat DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        //$this->addSql('CREATE TABLE equipement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, valo VARCHAR(255) NOT NULL, date_creat DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        //$this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, date_creat DATETIME NOT NULL, fk_lieu_id INT NOT NULL, fk_user_id INT NOT NULL, INDEX IDX_8933C4329A9D2EE0 (fk_lieu_id), INDEX IDX_8933C4325741EEB9 (fk_user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        //$this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, lieu_fk_id INT DEFAULT NULL, INDEX IDX_C53D045F6047BECB (lieu_fk_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        //$this->addSql('CREATE TABLE lieu (id INT AUTO_INCREMENT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, nom VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, date_creat DATETIME NOT NULL, etat VARCHAR(255) NOT NULL, categorie_fk_id INT DEFAULT NULL, arrondissement_id INT DEFAULT NULL, INDEX IDX_2F577D59500FF400 (categorie_fk_id), INDEX IDX_2F577D59407DBC11 (arrondissement_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        //$this->addSql('CREATE TABLE lieu_equipement (lieu_id INT NOT NULL, equipement_id INT NOT NULL, INDEX IDX_EDDE87476AB213CC (lieu_id), INDEX IDX_EDDE8747806F0F5C (equipement_id), PRIMARY KEY (lieu_id, equipement_id)) DEFAULT CHARACTER SET utf8mb4');
        //$this->addSql('CREATE TABLE secteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(25) NOT NULL, description VARCHAR(255) DEFAULT NULL, date_creat DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        //$this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, prenom VARCHAR(50) NOT NULL, pseudo VARCHAR(25) NOT NULL, fk_arrondissement_id INT DEFAULT NULL, INDEX IDX_8D93D6498E4A32E9 (fk_arrondissement_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        //$this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        //$this->addSql('ALTER TABLE arrondissement ADD CONSTRAINT FK_3A3B64C4E37485E1 FOREIGN KEY (fk_commune_id) REFERENCES commune (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF09A9D2EE0 FOREIGN KEY (fk_lieu_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF05741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4329A9D2EE0 FOREIGN KEY (fk_lieu_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4325741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F6047BECB FOREIGN KEY (lieu_fk_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE lieu ADD CONSTRAINT FK_2F577D59500FF400 FOREIGN KEY (categorie_fk_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE lieu ADD CONSTRAINT FK_2F577D59407DBC11 FOREIGN KEY (arrondissement_id) REFERENCES commune (id)');
        $this->addSql('ALTER TABLE lieu_equipement ADD CONSTRAINT FK_EDDE87476AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lieu_equipement ADD CONSTRAINT FK_EDDE8747806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498E4A32E9 FOREIGN KEY (fk_arrondissement_id) REFERENCES arrondissement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrondissement DROP FOREIGN KEY FK_3A3B64C4E37485E1');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF09A9D2EE0');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF05741EEB9');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4329A9D2EE0');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4325741EEB9');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F6047BECB');
        $this->addSql('ALTER TABLE lieu DROP FOREIGN KEY FK_2F577D59500FF400');
        $this->addSql('ALTER TABLE lieu DROP FOREIGN KEY FK_2F577D59407DBC11');
        $this->addSql('ALTER TABLE lieu_equipement DROP FOREIGN KEY FK_EDDE87476AB213CC');
        $this->addSql('ALTER TABLE lieu_equipement DROP FOREIGN KEY FK_EDDE8747806F0F5C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498E4A32E9');
        $this->addSql('DROP TABLE arrondissement');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commune');
        $this->addSql('DROP TABLE equipement');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE lieu_equipement');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
