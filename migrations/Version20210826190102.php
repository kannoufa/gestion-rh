<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210826190102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, nomar VARCHAR(255) NOT NULL, prenomar VARCHAR(255) NOT NULL, filiere VARCHAR(255) NOT NULL, grade VARCHAR(255) NOT NULL, cause VARCHAR(255) NOT NULL, duree VARCHAR(255) NOT NULL, apartir VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_765AE0C91C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attestation_salaire (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, created_at DATETIME NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_55BC32C01C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attestation_travail (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, nom_fr VARCHAR(255) NOT NULL, ppr INT NOT NULL, prenom_fr VARCHAR(255) NOT NULL, cni VARCHAR(10) NOT NULL, grade VARCHAR(255) NOT NULL, date_fonction DATETIME NOT NULL, created_at DATETIME NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_FEFEF56A1C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enregistrement_entree (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, nom_ar VARCHAR(255) NOT NULL, prenom_ar VARCHAR(255) NOT NULL, nom_fr VARCHAR(255) NOT NULL, prenom_fr VARCHAR(255) NOT NULL, date_naissance_ar DATETIME NOT NULL, lieu_naissance_ar VARCHAR(255) NOT NULL, nationalite_ar VARCHAR(255) NOT NULL, situation_familiale_ar VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, date_fonction DATETIME NOT NULL, created_at DATETIME NOT NULL, statut VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_82A6F7C11C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiche_renseignement (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, doti INT NOT NULL, cin VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, datenaiss DATETIME NOT NULL, lieunaiss VARCHAR(255) NOT NULL, nationalite VARCHAR(255) NOT NULL, etatcivil VARCHAR(255) NOT NULL, situationconj VARCHAR(255) DEFAULT NULL, doticonj VARCHAR(255) DEFAULT NULL, nbrenfant VARCHAR(255) DEFAULT NULL, grade VARCHAR(255) NOT NULL, fonction VARCHAR(255) NOT NULL, echelle VARCHAR(255) NOT NULL, indice VARCHAR(255) NOT NULL, daterecrut DATETIME NOT NULL, diplome VARCHAR(255) NOT NULL, adpersonnel VARCHAR(255) NOT NULL, adelectronique VARCHAR(255) NOT NULL, advacance VARCHAR(255) NOT NULL, telephonne VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, statut VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F3350DD01C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, id_demande INT NOT NULL, id_user INT NOT NULL, type_demande VARCHAR(255) NOT NULL, date_recu DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, recipient_id INT NOT NULL, title VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, is_read TINYINT(1) NOT NULL, INDEX IDX_B6BD307FF624B39D (sender_id), INDEX IDX_B6BD307FE92F8F78 (recipient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordre_mission (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, objet VARCHAR(255) NOT NULL, destination VARCHAR(255) NOT NULL, transport VARCHAR(255) NOT NULL, chauffeur VARCHAR(255) NOT NULL, membres VARCHAR(255) NOT NULL, date_depart DATETIME NOT NULL, heure_dep VARCHAR(255) NOT NULL, date_retour DATETIME NOT NULL, heure_retour VARCHAR(255) NOT NULL, frais VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_6BCEEE5E1C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnel (id INT AUTO_INCREMENT NOT NULL, ppr VARCHAR(255) DEFAULT NULL, cin VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, nom_ar VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, prenom_ar VARCHAR(50) NOT NULL, date_naissance DATETIME NOT NULL, date_recrutement DATETIME NOT NULL, sexe_ar VARCHAR(50) NOT NULL, nationalite_ar VARCHAR(50) NOT NULL, echellon VARCHAR(50) NOT NULL, date_effet_echelon DATETIME NOT NULL, anciennete_echelon VARCHAR(50) NOT NULL, grade_ar VARCHAR(50) NOT NULL, date_effet_grade DATETIME NOT NULL, anciennete_grade VARCHAR(50) NOT NULL, situation_administrative_ar VARCHAR(100) NOT NULL, fonction VARCHAR(100) NOT NULL, date_fonction DATETIME NOT NULL, anciennete_administrative VARCHAR(50) NOT NULL, etablissement_ar VARCHAR(100) NOT NULL, position VARCHAR(255) NOT NULL, date_position DATETIME NOT NULL, situation_familiale_ar VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_8D93D6491C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C91C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE attestation_salaire ADD CONSTRAINT FK_55BC32C01C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE attestation_travail ADD CONSTRAINT FK_FEFEF56A1C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE enregistrement_entree ADD CONSTRAINT FK_82A6F7C11C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE fiche_renseignement ADD CONSTRAINT FK_F3350DD01C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE92F8F78 FOREIGN KEY (recipient_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE ordre_mission ADD CONSTRAINT FK_6BCEEE5E1C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6491C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C91C109075');
        $this->addSql('ALTER TABLE attestation_salaire DROP FOREIGN KEY FK_55BC32C01C109075');
        $this->addSql('ALTER TABLE attestation_travail DROP FOREIGN KEY FK_FEFEF56A1C109075');
        $this->addSql('ALTER TABLE enregistrement_entree DROP FOREIGN KEY FK_82A6F7C11C109075');
        $this->addSql('ALTER TABLE fiche_renseignement DROP FOREIGN KEY FK_F3350DD01C109075');
        $this->addSql('ALTER TABLE ordre_mission DROP FOREIGN KEY FK_6BCEEE5E1C109075');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6491C109075');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FE92F8F78');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE attestation_salaire');
        $this->addSql('DROP TABLE attestation_travail');
        $this->addSql('DROP TABLE enregistrement_entree');
        $this->addSql('DROP TABLE fiche_renseignement');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE ordre_mission');
        $this->addSql('DROP TABLE personnel');
        $this->addSql('DROP TABLE `user`');
    }
}
