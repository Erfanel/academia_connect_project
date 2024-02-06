<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206151137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, programme LONGTEXT DEFAULT NULL, formateur_id INT DEFAULT NULL, INDEX IDX_9014574A155D8F51 (formateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, note NUMERIC(4, 2) DEFAULT NULL, apprenant_id INT DEFAULT NULL, matière_id INT DEFAULT NULL, INDEX IDX_CFBDFA14C5697D6D (apprenant_id), INDEX IDX_CFBDFA14B25992FD (matière_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, formation_suivie_id INT DEFAULT NULL, tuteur_designe_id INT DEFAULT NULL, INDEX IDX_1D1C63B3C365CD52 (formation_suivie_id), INDEX IDX_1D1C63B32FDCC3E2 (tuteur_designe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574A155D8F51 FOREIGN KEY (formateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14C5697D6D FOREIGN KEY (apprenant_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14B25992FD FOREIGN KEY (matière_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3C365CD52 FOREIGN KEY (formation_suivie_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B32FDCC3E2 FOREIGN KEY (tuteur_designe_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574A155D8F51');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14C5697D6D');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14B25992FD');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3C365CD52');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B32FDCC3E2');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
