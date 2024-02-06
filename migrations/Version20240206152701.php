<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206152701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matiere_formation (matiere_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_854E7299F46CD258 (matiere_id), INDEX IDX_854E72995200282E (formation_id), PRIMARY KEY(matiere_id, formation_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE matiere_formation ADD CONSTRAINT FK_854E7299F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_formation ADD CONSTRAINT FK_854E72995200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574A5200282E');
        $this->addSql('DROP INDEX IDX_9014574A5200282E ON matiere');
        $this->addSql('ALTER TABLE matiere DROP formation_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matiere_formation DROP FOREIGN KEY FK_854E7299F46CD258');
        $this->addSql('ALTER TABLE matiere_formation DROP FOREIGN KEY FK_854E72995200282E');
        $this->addSql('DROP TABLE matiere_formation');
        $this->addSql('ALTER TABLE matiere ADD formation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574A5200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('CREATE INDEX IDX_9014574A5200282E ON matiere (formation_id)');
    }
}
