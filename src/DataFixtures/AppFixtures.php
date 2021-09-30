<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Absence;
use App\Entity\Message;
use App\Entity\Vehicule;
use App\Entity\Chauffeur;
use App\Entity\Parametre;
use App\Entity\Personnel;
use App\Entity\Historique;
use App\Entity\OrdreMission;
use App\Entity\AttestationSalaire;
use App\Entity\AttestationTravail;
use App\Entity\DepartementService;
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
        $faker = Factory::create('fr_FR');
        $faker->seed(1337); // pour générer les meme données à chaque exécution
        $fakerAr = Factory::create('ar_SA'); // pour générer des noms en arabe
        $fakerAr->seed(1337);

        // Création de 100 personnels
        for ($i = 0; $i < 100; $i++) {

            $personnel = new Personnel();
            $personnel->setPpr($faker->numerify('#######'))
                ->setCin($faker->bothify('??######'))
                ->setNom($faker->lastName)
                ->setNomAr($fakerAr->lastName)
                ->setPrenom($faker->firstName)
                ->setPrenomAr($fakerAr->firstName)
                ->setDateNaissance($faker->dateTimeBetween('-60 years', '-25 years'))
                ->setDateRecrutement($faker->dateTimeBetween('-30 years', 'now'))
                ->setSexeAr($faker->randomElement(array('أنثى', 'ذكر')))
                ->setNationaliteAr('(ة)مغربي')
                ->setEchellon(mt_rand(8, 11))
                ->setDateEffetEchelon($faker->dateTimeBetween('-15 years'))
                ->setAncienneteEchelon(mt_rand(1, 7))
                ->setGradeAr($faker->randomElement(array('A', 'B', 'C')))
                ->setDateEffetGrade($faker->dateTimeBetween('-12 years'))
                ->setAncienneteGrade(mt_rand(1, 7))
                ->setSituationAdministrativeAr('(ة)أستاذ')
                ->setFonction($faker->randomElement(array('Professeur', 'Administrateur')))
                ->setDateFonction($faker->dateTimeBetween('-7 years'))
                ->setAncienneteAdministrative(mt_rand(1, 7))
                ->setEtablissementAr('كلية العلوم والتقنيات مراكش')
                ->setPosition(mt_rand(1, 7))
                ->setDatePosition($faker->dateTimeBetween('-3 years'))
                ->setSituationFamilialeAr($faker->randomElement(array('(ة)مطلق(ة)', 'متزوج(ة)', 'أعزب/عزباء', 'أرمل')))
                ->setEmail($fakerAr->email)
                ->setSexe($faker->randomElement(array('Masculin', 'Féminin')))
                ->setNationalite('Marocain(e)')
                ->setLieunaiss($faker->address)
                ->setEtatcivil($faker->randomElement(array('Marié(e)', 'Célibataire', 'Divorcé(e)', 'Veuf/Veuve')))
                ->setSituationconj($faker->randomElement(array('Enseignent(e)', 'Professeur')))
                ->setDoticonj($faker->numerify('#######'))
                ->setNbrenfant(mt_rand(0, 3))
                ->setGrade($faker->randomElement(array('A', 'B', 'C')))
                ->setEchelle(mt_rand(8, 11))
                ->setIndice(mt_rand(3, 10))
                ->setDiplome($faker->randomElement(array('Doctorat', 'Master', 'Licence')))
                ->setAdpersonnel($faker->address())
                ->setAdvacance(($faker->sentence(4)))
                ->setTelephonne($faker->numerify('06 ## ## ## ##'))
                ->setFilename($faker->randomElement(array('female.jpg', 'male.jpg', null)))
                ->setCreatedAt($faker->dateTimeBetween('-2 years'));
            $manager->persist($personnel);

            // Pour chaque personnel on crée un compte USER
            $user = new User();
            $password = $personnel->getDateNaissance()->format('dmY') . $personnel->getCin();
            $user->setPersonnel($personnel)
                ->setUsername($personnel->getPpr())
                ->setPassword($this->encoder->encodePassword($user, $password))
                ->setRoles($faker->randomElement(array(["ROLE_USER"], ["ROLE_ADMIN"])))
                ->setEmail($personnel->getEmail());
            $manager->persist($user);
            $users[] = $user;

            // Pour chaque personnel on crée 0 ou 4 documents de chaque type

            // Demande d'absence
            for ($j = 0; $j < mt_rand(0, 4); $j++) {
                $absence = new Absence();
                $absence->setPersonnel($personnel)
                    ->setNomar($personnel->getNomAr())
                    ->setPrenomar($personnel->getPrenomAr())
                    ->setFiliere($faker->randomElement(array('فيزياء', 'رياضيات', 'كيمياء', 'بيولوجيا', 'جيولوجيا')))
                    ->setGrade($faker->randomElement(array('ا', 'ب', 'ج')))
                    ->setCause($faker->randomElement(array('مرض', 'رخصة إستثنائية')))
                    ->setDuree(mt_rand(2, 15))
                    ->setPpr($personnel->getPpr())
                    ->setFileName('motif.pdf')
                    ->setApartir($faker->dateTimeBetween('-1 years'))
                    ->setJusquA($faker->dateTimeBetween('-1 years'))
                    ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                    ->setStatut($faker->randomElement(array('Validé par le département', 'Disponible', 'Reçu')));
                $manager->persist($absence);

                // Enregistrement dans l'historique
                $historique = new Historique();
                if ($absence->getStatut() == 'Reçu') {
                    $historique->setIdDemande($j + 1)
                        ->setIdUser($i + 1)
                        ->setTypeDemande("Absence")
                        ->setDateRecu($faker->dateTimeBetween('-1 years'))
                        ->setDateEnvoi($faker->dateTimeBetween('-1 years'))
                        ->setPpr($personnel->getPpr())
                        ->setNomPrenom($personnel->getNom() . ' ' . $personnel->getPrenom());
                    $manager->persist($historique);
                }
            }

            // Attestation de travail
            for ($j = 0; $j < mt_rand(0, 4); $j++) {
                $attestation_travail = new AttestationTravail();
                $attestation_travail->setPersonnel($personnel)
                    ->setNomFr($personnel->getNom())
                    ->setPpr($personnel->getPpr())
                    ->setPrenomFr($personnel->getPrenom())
                    ->setCni($personnel->getCin())
                    ->setGrade($personnel->getGradeAr())
                    ->setDateFonction($personnel->getDateFonction())
                    ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                    ->setStatut($faker->randomElement(array('Nouvelle demande', 'Disponible', 'Reçu')));
                $manager->persist($attestation_travail);

                // Enregistrement dans l'historique
                $historique = new Historique();
                if ($attestation_travail->getStatut() == 'Reçu') {
                    $historique->setIdDemande($j + 1)
                        ->setIdUser($i + 1)
                        ->setTypeDemande("AttestationTravail")
                        ->setDateRecu($faker->dateTimeBetween('-1 years'))
                        ->setDateEnvoi($faker->dateTimeBetween('-1 years'))
                        ->setPpr($personnel->getPpr())
                        ->setNomPrenom($personnel->getNom() . ' ' . $personnel->getPrenom());
                    $manager->persist($historique);
                }
            }

            // Attestation de salaire
            for ($j = 0; $j < mt_rand(0, 4); $j++) {
                $attestation_salaire = new AttestationSalaire();
                $attestation_salaire->setPersonnel($personnel)
                    ->setCreatedAt($faker->dateTimeBetween('-1 years'))
                    ->setType($faker->randomElement(array('Mois Actuel', 'Trimeste Actuel', 'Année Actuelle')))
                    ->setStatut($faker->randomElement(array('Nouvelle demande', 'Disponible', 'Reçu')));
                $manager->persist($attestation_salaire);

                // Enregistrement dans l'historique
                $historique = new Historique();
                if ($attestation_salaire->getStatut() == 'Reçu') {
                    $historique->setIdDemande($j + 1)
                        ->setIdUser($i + 1)
                        ->setTypeDemande("AttestationSalaire")
                        ->setDateRecu($faker->dateTimeBetween('-1 years'))
                        ->setDateEnvoi($faker->dateTimeBetween('-1 years'))
                        ->setPpr($personnel->getPpr())
                        ->setNomPrenom($personnel->getNom() . ' ' . $personnel->getPrenom());
                    $manager->persist($historique);
                }
            }

            // Ordre de mission
            for ($j = 0; $j < mt_rand(0, 4); $j++) {
                $ordre = new OrdreMission();
                $ordre->setPersonnel($personnel)
                    ->setNom($personnel->getNom())
                    ->setPrenom($personnel->getPrenom())
                    ->setObjet('Sortie à ' . $faker->sentence(4))
                    ->setDestination($faker->address)
                    ->setTransport('Véhicule personnel - MATRICULE : ' . $faker->bothify('######') . '| A |' . '26')
                    ->setChauffeur($personnel->getNom() . ' ' . $personnel->getPrenom())
                    ->setMembres(mt_rand(10, 80) . ' personnes')
                    ->setDateDepart($faker->dateTimeBetween('-1 years'))
                    ->setHeureDep($faker->randomElement(array('08:30', '07:30', '09:00')))
                    ->setDateRetour($ordre->getDateDepart())
                    ->setHeureRetour($faker->randomElement(array('18:30', '17:30', '16:00')))
                    ->setFrais($faker->randomElement(array('Avec frais', 'Sans frais')))
                    ->setFileName($faker->randomElement(array('motif.pdf', null)))
                    ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                    ->setStatut($faker->randomElement(array('Validé par le département', 'Disponible', 'Reçu')));
                $manager->persist($ordre);

                // Enregistrement dans l'historique
                $historique = new Historique();
                if ($ordre->getStatut() == 'Reçu') {
                    $historique->setIdDemande($j + 1)
                        ->setIdUser($i + 1)
                        ->setTypeDemande("OrdreMission")
                        ->setDateRecu($faker->dateTimeBetween('-1 years'))
                        ->setDateEnvoi($faker->dateTimeBetween('-1 years'))
                        ->setPpr($personnel->getPpr())
                        ->setNomPrenom($personnel->getNom() . ' ' . $personnel->getPrenom());
                    $manager->persist($historique);
                }
            }
            $personnels[] = $personnel;
        }

        //Création des département

        #math
        $departement1 = new DepartementService();
        $departement1->setNomFr('Mathématiques')
            ->setNomAr('رياضيات')
            ->setChef($faker->randomelement($users));
        $manager->persist($departement1);
        $departements[] = $departement1;

        #info
        $departement2 = new DepartementService();
        $departement2->setNomFr('Informatique')
            ->setNomAr('اعلاميات')
            ->setChef($faker->randomelement($users));
        $manager->persist($departement2);
        $departements[] = $departement2;

        #biologie
        $departement3 = new DepartementService();
        $departement3->setNomFr('Biologie')
            ->setNomAr('بيولوجيا')
            ->setChef($faker->randomelement($users));
        $manager->persist($departement3);
        $departements[] = $departement3;

        #chimie
        $departement4 = new DepartementService();
        $departement4->setNomFr('Sciences chimiques')
            ->setNomAr('كيمياء')
            ->setChef($faker->randomelement($users));
        $manager->persist($departement4);
        $departements[] = $departement4;

        #physique
        $departement5 = new DepartementService();
        $departement5->setNomFr('Physique appliquée')
            ->setNomAr('فيزياء')
            ->setChef($faker->randomelement($users));
        $manager->persist($departement5);
        $departements[] = $departement5;

        #géologie
        $departement6 = new DepartementService();
        $departement6->setNomFr('Sciences de la terre')
            ->setNomAr('علوم الارض')
            ->setChef($faker->randomelement($users));
        $manager->persist($departement6);
        $departements[] = $departement6;

        #G.C
        $departement7 = new DepartementService();
        $departement7->setNomFr('Génie civil')
            ->setNomAr('الهندسة المدنية')
            ->setChef($faker->randomelement($users));
        $manager->persist($departement7);
        $departements[] = $departement7;

        // déterminer des personnels pour chaque département
        foreach ($personnels as $personnel) {
            $personnel->setDepartementService($faker->randomelement($departements));
            $manager->persist($personnel);
        }

        // Messagerie
        foreach ($users as $user) {
            for ($i = 0; $i < mt_rand(0, 3); $i++) {
                $message = new Message();
                $message->setSender($user)
                    ->setRecipient($faker->randomelement($users))
                    ->setTitle($faker->sentence(4))
                    ->setMessage(join($faker->paragraphs($faker->randomelement(array(2, 5)))))
                    ->setCreatedAt($faker->dateTimeBetween('-1 years'))
                    ->setIsread(true);
                $manager->persist($message);
            }
        }


        // Véhicule de service
        $v1 = new Vehicule();
        $v1->setNom('Partner')->setMatricule('M166776');
        $manager->persist($v1);

        $v2 = new Vehicule();
        $v2->setNom('Duster')->setMatricule('M204028');
        $manager->persist($v2);

        $v3 = new Vehicule();
        $v3->setNom('Minibus')->setMatricule('M155873');
        $manager->persist($v3);

        $v4 = new Vehicule();
        $v4->setNom('Volvo')->setMatricule('M201083');
        $manager->persist($v4);

        // Chauffeurs
        $chaffeur1 = new Chauffeur();
        $chaffeur1->setNomPrenom($faker->name);
        $manager->persist($chaffeur1);

        $chaffeur2 = new Chauffeur();
        $chaffeur2->setNomPrenom($faker->name);
        $manager->persist($chaffeur2);

        // Paramètres
        $parametre = new Parametre();
        $parametre->setEnTeteOrdreMission('EnTeteOrdreMission.png')->setLogo('logo.png');
        $manager->persist($parametre);

        $manager->flush();
    }
}