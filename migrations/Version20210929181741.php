<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210929181741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, nomar VARCHAR(255) NOT NULL, prenomar VARCHAR(255) NOT NULL, filiere VARCHAR(255) NOT NULL, grade VARCHAR(255) NOT NULL, cause VARCHAR(255) NOT NULL, duree INT NOT NULL, apartir DATETIME NOT NULL, jusqu_a DATETIME NOT NULL, ppr VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, statut VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, INDEX IDX_765AE0C91C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attestation_salaire (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, created_at DATETIME NOT NULL, statut VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_55BC32C01C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attestation_travail (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, nom_fr VARCHAR(255) NOT NULL, ppr INT NOT NULL, prenom_fr VARCHAR(255) NOT NULL, cni VARCHAR(10) NOT NULL, grade VARCHAR(255) NOT NULL, date_fonction DATETIME NOT NULL, created_at DATETIME NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_FEFEF56A1C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chauffeur (id INT AUTO_INCREMENT NOT NULL, nom_prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement_service (id INT AUTO_INCREMENT NOT NULL, chef_id INT DEFAULT NULL, nom_fr VARCHAR(255) NOT NULL, nom_ar VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E36D4E0D150A48F1 (chef_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, id_demande INT NOT NULL, id_user INT NOT NULL, nom_prenom VARCHAR(255) NOT NULL, ppr VARCHAR(255) NOT NULL, type_demande VARCHAR(255) NOT NULL, date_envoi DATETIME NOT NULL, date_recu DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, recipient_id INT NOT NULL, title VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, is_read TINYINT(1) NOT NULL, INDEX IDX_B6BD307FF624B39D (sender_id), INDEX IDX_B6BD307FE92F8F78 (recipient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordre_mission (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, objet VARCHAR(255) NOT NULL, destination VARCHAR(255) NOT NULL, transport VARCHAR(255) NOT NULL, chauffeur VARCHAR(255) NOT NULL, membres VARCHAR(255) NOT NULL, date_depart DATETIME NOT NULL, heure_dep VARCHAR(255) NOT NULL, date_retour DATETIME NOT NULL, heure_retour VARCHAR(255) NOT NULL, frais VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, statut VARCHAR(255) NOT NULL, filename VARCHAR(255) DEFAULT NULL, INDEX IDX_6BCEEE5E1C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parametre (id INT AUTO_INCREMENT NOT NULL, logo VARCHAR(255) NOT NULL, en_tete_ordre_mission VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnel (id INT AUTO_INCREMENT NOT NULL, departement_service_id INT DEFAULT NULL, ppr VARCHAR(255) DEFAULT NULL, cin VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, nom_ar VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, prenom_ar VARCHAR(50) NOT NULL, date_naissance DATETIME NOT NULL, date_recrutement DATETIME NOT NULL, sexe_ar VARCHAR(50) NOT NULL, sexe VARCHAR(50) NOT NULL, nationalite_ar VARCHAR(50) NOT NULL, nationalite VARCHAR(50) NOT NULL, echellon VARCHAR(50) NOT NULL, date_effet_echelon DATETIME NOT NULL, anciennete_echelon INT NOT NULL, grade_ar VARCHAR(50) NOT NULL, date_effet_grade DATETIME NOT NULL, anciennete_grade INT NOT NULL, situation_administrative_ar VARCHAR(100) NOT NULL, fonction VARCHAR(100) NOT NULL, date_fonction DATETIME NOT NULL, anciennete_administrative INT NOT NULL, etablissement_ar VARCHAR(100) NOT NULL, position VARCHAR(255) NOT NULL, date_position DATETIME NOT NULL, situation_familiale_ar VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, lieunaiss VARCHAR(255) NOT NULL, etatcivil VARCHAR(255) NOT NULL, situationconj VARCHAR(255) DEFAULT NULL, doticonj VARCHAR(255) DEFAULT NULL, nbrenfant INT DEFAULT NULL, grade VARCHAR(255) NOT NULL, echelle VARCHAR(255) NOT NULL, indice VARCHAR(255) NOT NULL, diplome VARCHAR(255) NOT NULL, adpersonnel VARCHAR(255) NOT NULL, advacance VARCHAR(255) DEFAULT NULL, telephonne VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, filename VARCHAR(255) DEFAULT NULL, INDEX IDX_A6BCF3DE336029EE (departement_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_8D93D6491C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, matricule VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C91C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE attestation_salaire ADD CONSTRAINT FK_55BC32C01C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE attestation_travail ADD CONSTRAINT FK_FEFEF56A1C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE departement_service ADD CONSTRAINT FK_E36D4E0D150A48F1 FOREIGN KEY (chef_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE92F8F78 FOREIGN KEY (recipient_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE ordre_mission ADD CONSTRAINT FK_6BCEEE5E1C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE personnel ADD CONSTRAINT FK_A6BCF3DE336029EE FOREIGN KEY (departement_service_id) REFERENCES departement_service (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6491C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnel DROP FOREIGN KEY FK_A6BCF3DE336029EE');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C91C109075');
        $this->addSql('ALTER TABLE attestation_salaire DROP FOREIGN KEY FK_55BC32C01C109075');
        $this->addSql('ALTER TABLE attestation_travail DROP FOREIGN KEY FK_FEFEF56A1C109075');
        $this->addSql('ALTER TABLE ordre_mission DROP FOREIGN KEY FK_6BCEEE5E1C109075');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6491C109075');
        $this->addSql('ALTER TABLE departement_service DROP FOREIGN KEY FK_E36D4E0D150A48F1');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FE92F8F78');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE attestation_salaire');
        $this->addSql('DROP TABLE attestation_travail');
        $this->addSql('DROP TABLE chauffeur');
        $this->addSql('DROP TABLE departement_service');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE ordre_mission');
        $this->addSql('DROP TABLE parametre');
        $this->addSql('DROP TABLE personnel');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE vehicule');
    }
}
