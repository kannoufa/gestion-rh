<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210907224519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE departement_service (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD departement_service_id INT DEFAULT NULL, ADD email VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649336029EE FOREIGN KEY (departement_service_id) REFERENCES departement_service (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649336029EE ON user (departement_service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649336029EE');
        $this->addSql('DROP TABLE departement_service');
        $this->addSql('DROP INDEX IDX_8D93D649336029EE ON `user`');
        $this->addSql('ALTER TABLE `user` DROP departement_service_id, DROP email');
    }
}
