<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Personnel;
use App\Repository\ParametreRepository;
use App\Repository\HistoriqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Service
{

    protected $entityManager;
    protected $repoService;
    protected $historyRepo;
    protected $paramRepo;
    protected $paginator;
    protected $encoder;

    public function __construct(SluggerInterface $slugger, ParametreRepository $paramRepo, HistoriqueRepository $historyRepo, UserPasswordEncoderInterface $encoder, RepositoryService $repoService, EntityManagerInterface $entityManager, PaginatorInterface $paginator)
    {
        $this->encoder          = $encoder;
        $this->paramRepo        = $paramRepo;
        $this->paginator        = $paginator;
        $this->repoService      = $repoService;
        $this->historyRepo      = $historyRepo;
        $this->entityManager    = $entityManager;
        $this->slugger    = $slugger;
    }

    /**
     * Supprimer un objet de la base de données
     */
    public function delete(string $repo, int $id)
    {
        $object = $this->repoService->getRepository($repo)['repository']->find($id);
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }

    /**
     * Historique d'un utilisateur
     */
    public function getHistoryUser($id_user, $request)
    {
        $history = $this->paginator->paginate(
            $this->historyRepo->findbyUserIdQuery($id_user),
            $request->query->getInt('page', 1),
            30
        );
        return $history;
    }

    /**
     * ajouter un utilisateur associé à un personnel
     */
    public function addUser($personnel)
    {
        $user = new User();
        $password = $personnel->getDateNaissance()->format('dmY') . $personnel->getCin();
        $user->setPersonnel($personnel)
            ->setEmail($personnel->getEmail())
            ->setUsername($personnel->getPpr())
            ->setPassword($this->encoder->encodePassword($user, $password))
            ->setRoles(["ROLE_USER"]);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * modifie les paramètres (en tete de l'ordre de mission ou le logo de la FSTG)
     */
    public function modifie($form, $parametre)
    {
        if (!($form->get('logoFile')->getData() instanceof UploadedFile)) {
            $parametre->setLogo($this->paramRepo->findLastInserted()->getLogo());
        }
        if (!($form->get('enTeteOrdreMissionFile')->getData() instanceof UploadedFile)) {
            $parametre->setEnTeteOrdreMission($this->paramRepo->findLastInserted()->getEnTeteOrdreMission());
        }
        $this->entityManager->persist($parametre);
        $this->entityManager->flush();
    }

    /**
     * retourner un tableau des personnels
     * on aura besoin de cette fct pour exporter les données dans l'EXCEL
     */
    public function getPersonnel(): array
    {
        $list = [];
        $personnels = $this->entityManager->getRepository(Personnel::class)->findAll();

        foreach ($personnels as $personnel) {
            $list[] = [
                $personnel->getPpr(),
                $personnel->getCin(),
                $personnel->getNom(),
                $personnel->getNomAr(),
                $personnel->getPrenom(),
                $personnel->getPrenomAr(),
                $personnel->getDateNaissance(),
                $personnel->getDateRecrutement(),
                $personnel->getSexeAr(),
                $personnel->getNationaliteAr(),
                $personnel->getEchellon(),
                $personnel->getDateEffetEchelon(),
                $personnel->getAncienneteEchelon(),
                $personnel->getGradeAr(),
                $personnel->getAncienneteGrade(),
                $personnel->getDateEffetGrade(),
                $personnel->getSituationAdministrativeAr(),
                $personnel->getFonction(),
                $personnel->getDateFonction(),
                $personnel->getAncienneteAdministrative(),
                $personnel->getEtablissementAr(),
                $personnel->getPosition(),
                $personnel->getDatePosition(),
                $personnel->getSituationFamilialeAr(),
            ];
        }
        return $list;
    }

    /**
     * exportation des données dans un fichier EXCEL
     */
    public function createSpreadsheet()
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Personnels List');

        $sheet->getCell('A1')->setValue('PPR');
        $sheet->getCell('B1')->setValue('CIN');
        $sheet->getCell('C1')->setValue('NOM');
        $sheet->getCell('D1')->setValue('NOM AR');
        $sheet->getCell('E1')->setValue('PRENOM');
        $sheet->getCell('F1')->setValue('PRENOM AR');
        $sheet->getCell('G1')->setValue('DATE DE NAISSANCE');
        $sheet->getCell('H1')->setValue('DATE DE RECRUTEMENT');
        $sheet->getCell('I1')->setValue('SEXE AR');
        $sheet->getCell('J1')->setValue('NATIONALITE ARABE');
        $sheet->getCell('K1')->setValue('ECHELLON');
        $sheet->getCell('L1')->setValue('DATE EFFET ECHELON');
        $sheet->getCell('M1')->setValue('ANCIENNETE ECHELON');
        $sheet->getCell('N1')->setValue('GRADE ARABE');
        $sheet->getCell('O1')->setValue('DATE EFFET GRADE');
        $sheet->getCell('P1')->setValue('ANCIENNETE GRADE');
        $sheet->getCell('Q1')->setValue('SITUATION ADMINISTRATIVE ARABE');
        $sheet->getCell('R1')->setValue('FONCTION');
        $sheet->getCell('S1')->setValue('DATE FONCTION');
        $sheet->getCell('T1')->setValue('ANCIENNETE ADMINISTRATIVE');
        $sheet->getCell('U1')->setValue('ETABLISSEMENT ARABE');
        $sheet->getCell('V1')->setValue('POSITION');
        $sheet->getCell('W1')->setValue('DATE POSITION');
        $sheet->getCell('X1')->setValue('SITUATION FAMILIALE ARABE');

        // Increase row cursor after header write
        $sheet->fromArray($this->getPersonnel(), null, 'A2', true);

        $writer = new Xlsx($spreadsheet);
        $writer->save('list_personnel.xlsx');
    }
}