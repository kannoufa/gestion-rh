<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Absence;
use App\Entity\Personnel;
use App\Entity\OrdreMission;
use App\Entity\AttestationSalaire;
use App\Entity\AttestationTravail;
use App\Entity\FicheRenseignement;
use App\Entity\EnregistrementEntree;
use App\Entity\Historique;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * Encodeur de mot de passe
     *
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $fakerAr = Factory::create('ar_SA'); // pour générer des noms en arabe

        // Création de 10 personnels
        for ($i = 0; $i < 20; $i++){

            $personnel = new Personnel();
            $personnel->setPpr($faker->numerify('#######'))
                      ->setCin($faker->bothify('??######'))
                      ->setNom($faker->lastName)
                      ->setNomAr($fakerAr->lastName)
                      ->setPrenom($faker->firstName)
                      ->setPrenomAr($fakerAr->firstName)
                      ->setDateNaissance($faker->dateTimeBetween('-60 years','-25 years'))
                      ->setDateRecrutement($faker->dateTimeBetween('-30 years', 'now'))
                      ->setSexeAr($faker->randomElement(array ('أنثى','ذكر')))
                      ->setNationaliteAr('مغربي')
                      ->setEchellon(mt_rand(8, 11))
                      ->setDateEffetEchelon($faker->dateTimeBetween('-15 years'))
                      ->setAncienneteEchelon(mt_rand(1,7) . 'ans')
                      ->setGradeAr($faker->randomElement(array ('A','B', 'C')))
                      ->setDateEffetGrade($faker->dateTimeBetween('-12 years'))
                      ->setAncienneteGrade(mt_rand(1,7) . 'ans')
                      ->setSituationAdministrativeAr('أستاذ')
                      ->setFonction($faker->randomElement(array ('Professeur','Administrateur')))
                      ->setDateFonction($faker->dateTimeBetween('-7 years'))
                      ->setAncienneteAdministrative(mt_rand(1,7) . 'ans')
                      ->setEtablissementAr('كلية العلوم والتقنيات مراكش')
                      ->setPosition(mt_rand(1,7))
                      ->setDatePosition($faker->dateTimeBetween('-3 years'))
                      ->setSituationFamilialeAr($faker->randomElement(array ('مطلق','متزوج', 'أعزب', 'أرمل')))
                      ->setEmail($fakerAr->email)
            ;
            $manager->persist($personnel);
                
            // Pour chaque personnel on crée un compte USER
            $user = new User();
            $user->setPersonnel($personnel)
                 ->setUsername($personnel->getNom().' '.$personnel->getPrenom())
                 ->setPassword($this->encoder->encodePassword($user, $personnel->getPpr()))
                 ->setRoles($faker->randomElement(array (["ROLE_USER"],["ROLE_ADMIN"])))
            ;
            $manager->persist($user);

            // Pour chaque personnel on crée entre 0 et 3 documents de chaque type

            // Demande d'absence
            for ($j = 0; $j < mt_rand(0,3); $j++){
                $absence = new Absence();
                $absence->setPersonnel($personnel)
                        ->setNomar($personnel->getNomAr())
                        ->setPrenomar($personnel->getPrenomAr())
                        ->setFiliere($faker->randomElement(array ('فيزياء','رياضيات','كيمياء','بيولوجيا','جيولوجيا')))
                        ->setGrade($faker->randomElement(array ('ا','ب', 'ج')))
                        ->setCause($faker->randomElement(array ('مرض','زواج')))
                        ->setDuree(mt_rand(2,15) . ' يوم')
                        ->setApartir($faker->dateTimeBetween('-1 years')->format('d-m-Y'))
                        ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                        ->setStatut('Nouveau demande')
                ;
                $manager->persist($absence);

                // Enregistrement dans l'historique
                $historique = new Historique();
                $historique->setIdDemande($j+1)
                           ->setIdUser($i+1)
                           ->setTypeDemande("Demande d'absence")
                           ->setDateRecu($faker->dateTimeBetween('-1 years'))
                ;
                $manager->persist($historique);

            }

            // Attestation de travail
            for ($j = 0; $j < mt_rand(0,3); $j++){
                $attestation_travail = new AttestationTravail();
                $attestation_travail->setPersonnel($personnel)
                                    ->setNomFr($personnel->getNom())
                                    ->setPpr($personnel->getPpr())
                                    ->setPrenomFr($personnel->getPrenom())
                                    ->setCni($personnel->getCin())
                                    ->setGrade($personnel->getGradeAr())
                                    ->setDateFonction($personnel->getDateFonction())
                                    ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                                    ->setStatut('Nouveau demande')
                ; 
                $manager->persist($attestation_travail);   
                
                // Enregistrement dans l'historique
                $historique = new Historique();
                $historique->setIdDemande($j+1)
                           ->setIdUser($i+1)
                           ->setTypeDemande("Attestation de travail")
                           ->setDateRecu($faker->dateTimeBetween('-1 years'))
                ;
                $manager->persist($historique);
            }

            // Attestation de salaire
            for ($j = 0; $j < mt_rand(0,3); $j++){
                $attestation_salaire = new AttestationSalaire();
                $attestation_salaire->setPersonnel($personnel)
                                    ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                                    ->setStatut('Nouveau demande')
                ;
                $manager->persist($attestation_salaire);

                // Enregistrement dans l'historique
                $historique = new Historique();
                $historique->setIdDemande($j+1)
                           ->setIdUser($i+1)
                           ->setTypeDemande("Attestation de salaire")
                           ->setDateRecu($faker->dateTimeBetween('-1 years'))
                ;
                $manager->persist($historique);
            }

            // Fiche de renseignement
                $fiche = new FicheRenseignement();
                $fiche->setPersonnel($personnel)
                      ->setDoti($personnel->getPpr())
                      ->setCin($personnel->getCin())
                      ->setNom($personnel->getNom())
                      ->setPrenom($personnel->getPrenom())
                      ->setSexe($faker->randomElement(array ('Masculin','Féminin')))
                      ->setDatenaiss($personnel->getDateNaissance())
                      ->setLieunaiss($faker->address)
                      ->setNationalite('Marocain(e)')
                      ->setEtatcivil($faker->randomElement(array ('Marié','Célibataire', 'Divorcé', 'Veuf')))
                      ->setSituationconj($faker->randomElement(array ('Enseignent(e)','Professeur')))
                      ->setDoticonj($faker->numerify('#######'))
                      ->setNbrenfant(mt_rand(0,3))
                      ->setGrade($personnel->getGradeAr())
                      ->setFonction($personnel->getFonction())
                      ->setEchelle($personnel->getEchellon())
                      ->setIndice(mt_rand(3,10))
                      ->setDaterecrut($personnel->getDateRecrutement())
                      ->setDiplome($faker->randomElement(array ('Doctorat','Master', 'DUT')))
                      ->setAdpersonnel($faker->address())
                      ->setAdelectronique($personnel->getEmail())
                      ->setAdvacance(($faker->sentence(4)))
                      ->setTelephonne($faker->numerify('06 ## ## ## ##'))
                      ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                      ->setStatut('Nouveau demande')
                ;
                $manager->persist($fiche);

                // enregistrent d'entree correspondant
                $entree = new EnregistrementEntree();
                $entree->setPersonnel($personnel)
                       ->setNomAr($personnel->getNomAr())
                       ->setPrenomAr($personnel->getPrenomAr())
                       ->setNomFr($personnel->getNom())
                       ->setPrenomFr($personnel->getPrenom())
                       ->setDateNaissanceAr($fiche->getDatenaiss())
                       ->setLieuNaissanceAr($fakerAr->address)
                       ->setNationaliteAr($personnel->getNationaliteAr())
                       ->setSituationFamilialeAr($personnel->getSituationFamilialeAr())
                       ->setAdresse($fakerAr->address)
                       ->setDateFonction($personnel->getDateFonction())
                       ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                       ->setStatut('Nouveau demande')
                ;
                $manager->persist($entree);

            // Ordre de mission
            for ($j = 0; $j < mt_rand(0,3); $j++){
                $ordre = new OrdreMission();
                $ordre->setPersonnel($personnel)
                      ->setNom($personnel->getNom())
                      ->setPrenom($personnel->getPrenom())
                      ->setObjet('Sortie à ' . $faker->sentence(4))
                      ->setDestination($faker->address)
                      ->setTransport('Bus - MATRICULE : '.$faker->bothify('######') .'| A |'. '26')
                      ->setChauffeur($fakerAr->name())
                      ->setMembres(mt_rand(10, 80) . ' personnes')
                      ->setDateDepart($faker->dateTimeBetween('-1 years'))
                      ->setHeureDep($faker->randomElement(array ('08:30','07:30', '09:00')))
                      ->setDateRetour($ordre->getDateDepart())
                      ->setHeureRetour($faker->randomElement(array ('18:30','17:30', '16:00')))
                      ->setFrais($faker->randomElement(array ('Avec frais','Sans frais')))
                      ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                      ->setStatut('Nouveau demande')
                ;
                $manager->persist($ordre);

                // Enregistrement dans l'historique
                $historique = new Historique();
                $historique->setIdDemande($j+1)
                           ->setIdUser($i+1)
                           ->setTypeDemande("Ordre de mission")
                           ->setDateRecu($faker->dateTimeBetween('-1 years'))
                ;
                $manager->persist($historique);
            }

        }

        $manager->flush();
    }
}