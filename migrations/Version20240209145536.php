<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240209145536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, formateur_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, programme LONGTEXT DEFAULT NULL, INDEX IDX_9014574A155D8F51 (formateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere_formation (matiere_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_854E7299F46CD258 (matiere_id), INDEX IDX_854E72995200282E (formation_id), PRIMARY KEY(matiere_id, formation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, matiere_id INT DEFAULT NULL, apprenant_id INT DEFAULT NULL, note NUMERIC(4, 2) NOT NULL, evaluation VARCHAR(255) DEFAULT NULL, INDEX IDX_CFBDFA14F46CD258 (matiere_id), INDEX IDX_CFBDFA14C5697D6D (apprenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, formation_suivie_id INT DEFAULT NULL, tuteur_assigne_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), INDEX IDX_1D1C63B3C365CD52 (formation_suivie_id), INDEX IDX_1D1C63B3162F335D (tuteur_assigne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574A155D8F51 FOREIGN KEY (formateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE matiere_formation ADD CONSTRAINT FK_854E7299F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_formation ADD CONSTRAINT FK_854E72995200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14C5697D6D FOREIGN KEY (apprenant_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3C365CD52 FOREIGN KEY (formation_suivie_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3162F335D FOREIGN KEY (tuteur_assigne_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574A155D8F51');
        $this->addSql('ALTER TABLE matiere_formation DROP FOREIGN KEY FK_854E7299F46CD258');
        $this->addSql('ALTER TABLE matiere_formation DROP FOREIGN KEY FK_854E72995200282E');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14F46CD258');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14C5697D6D');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3C365CD52');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3162F335D');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE matiere_formation');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
