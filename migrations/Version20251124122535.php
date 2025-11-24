<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251124122535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis ADD fk_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF09A9D2EE0 FOREIGN KEY (fk_lieu_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF05741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF05741EEB9 ON avis (fk_user_id)');
        $this->addSql('ALTER TABLE categorie ADD status_visu VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4329A9D2EE0 FOREIGN KEY (fk_lieu_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F6047BECB FOREIGN KEY (lieu_fk_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE lieu ADD valo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE lieu ADD CONSTRAINT FK_2F577D59500FF400 FOREIGN KEY (categorie_fk_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE lieu ADD CONSTRAINT FK_2F577D59407DBC11 FOREIGN KEY (arrondissement_id) REFERENCES commune (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498E4A32E9 FOREIGN KEY (fk_arrondissement_id) REFERENCES arrondissement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF09A9D2EE0');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF05741EEB9');
        $this->addSql('DROP INDEX IDX_8F91ABF05741EEB9 ON avis');
        $this->addSql('ALTER TABLE avis DROP fk_user_id');
        $this->addSql('ALTER TABLE categorie DROP status_visu');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4329A9D2EE0');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F6047BECB');
        $this->addSql('ALTER TABLE lieu DROP FOREIGN KEY FK_2F577D59500FF400');
        $this->addSql('ALTER TABLE lieu DROP FOREIGN KEY FK_2F577D59407DBC11');
        $this->addSql('ALTER TABLE lieu DROP valo');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498E4A32E9');
    }
}
