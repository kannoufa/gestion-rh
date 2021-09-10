<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210907230750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement_service ADD chef_id INT DEFAULT NULL, ADD nom_ar VARCHAR(255) NOT NULL, CHANGE nom nom_fr VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE departement_service ADD CONSTRAINT FK_E36D4E0D150A48F1 FOREIGN KEY (chef_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E36D4E0D150A48F1 ON departement_service (chef_id)');
        $this->addSql('ALTER TABLE personnel ADD departement_service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personnel ADD CONSTRAINT FK_A6BCF3DE336029EE FOREIGN KEY (departement_service_id) REFERENCES departement_service (id)');
        $this->addSql('CREATE INDEX IDX_A6BCF3DE336029EE ON personnel (departement_service_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649336029EE');
        $this->addSql('DROP INDEX IDX_8D93D649336029EE ON user');
        $this->addSql('ALTER TABLE user DROP departement_service_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement_service DROP FOREIGN KEY FK_E36D4E0D150A48F1');
        $this->addSql('DROP INDEX UNIQ_E36D4E0D150A48F1 ON departement_service');
        $this->addSql('ALTER TABLE departement_service ADD nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP chef_id, DROP nom_fr, DROP nom_ar');
        $this->addSql('ALTER TABLE personnel DROP FOREIGN KEY FK_A6BCF3DE336029EE');
        $this->addSql('DROP INDEX IDX_A6BCF3DE336029EE ON personnel');
        $this->addSql('ALTER TABLE personnel DROP departement_service_id');
        $this->addSql('ALTER TABLE `user` ADD departement_service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649336029EE FOREIGN KEY (departement_service_id) REFERENCES departement_service (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649336029EE ON `user` (departement_service_id)');
    }
}
