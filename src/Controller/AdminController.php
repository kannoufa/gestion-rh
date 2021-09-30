<?php

namespace App\Controller;

use App\Service\Service;
use App\Entity\Parametre;
use App\Entity\Personnel;
use App\Form\ParametreType;
use App\Form\PersonnelType;
use App\Form\AdminOrdreType;
use App\Entity\AbsenceSearch;
use App\Entity\PersonnelSearch;
use App\Form\AbsenceSearchType;
use App\Entity\HistoriqueSearch;
use App\Service\DocumentService;
use App\Form\PersonnelSearchType;
use App\Entity\DepartementService;
use App\Form\HistoriqueSearchType;
use App\Service\RepositoryService;
use App\Repository\ParametreRepository;
use App\Repository\PersonnelRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OrdreMissionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin", methods="GET|POST")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', []);
    }

    /**
     * @Route("/admin/ajout-personnel", name="admin_add_personnel")
     * @Route("/admin/modifier/Personnel/{id}", name="admin_set_personnel")
     */
    public function AddPersonnel(Service $service, Personnel $personnel = null, $id = null, Request $request, PersonnelRepository $repo, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $titre = 'Modification des données';
        if (!$id) {
            $personnel = new personnel();
            $titre = 'ajout d\'un personnel';
        }
        $form = $this->createForm(PersonnelType::class, $personnel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $personnel->setSexe(Personnel::SEXE[$form->get('sexe')->getData()]);
            $personnel->setSexeAr(Personnel::SEXEAR[$form->get('sexe_ar')->getData()]);
            $personnel->setEtatcivil(Personnel::ETATCIVIL[$form->get('etatcivil')->getData()]);
            $personnel->setSituationFamilialeAr(Personnel::SITUATIONFAMILIAIREAR[$form->get('situation_familiale_ar')->getData()]);
            $entityManager->persist($personnel);
            $entityManager->flush();
            if (!$id)
                $service->addUser($personnel);

            return $this->redirectToRoute('admin_liste_documents', ['repo' => 'Personnel']);
        }
        return $this->render('admin/personnel/ajout_personnel.html.twig', [
            'titre' => $titre,
            'form' => $form->createView(),
            'personnel' => $repo->findLastInserted(),
            'editMode' => $personnel->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/parametres", name="admin_parametres", methods="GET|POST")
     */
    public function edit(Request $request, Service $service, ParametreRepository $repo)
    {
        $parametre = new Parametre();
        $form = $this->createForm(ParametreType::class, $parametre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->modifie($form, $parametre);
        }

        return $this->render('admin/parametres/parametres.html.twig', [
            'parametre' => $repo->findLastInserted(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/delete/parametre/{repo}/{id}", name="admin_delete")
     */
    public function delete($repo, $id, Service $service): Response
    {
        $service->delete($repo, $id);
        return $this->redirectToRoute('admin_liste_documents', ['repo' => $repo]);
    }

    /**
     * @Route("/admin/parametre-create/{repo}", name="admin_parametre")
     * @Route("/admin/modifier/{repo}/{id}", name="admin_set_departement")
     */
    public function parametre($repo, $id = null, RepositoryService $repoService, DepartementService $departement = null, EntityManagerInterface $entityManager, Request $request): Response
    {
        $array = $repoService->getRepository($repo);

        if (!$id)
            $document = $array['document'];
        else
            $document = $departement;
        $form = $this->createForm($array['type'], $document);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($document);
            $entityManager->flush();
            return $this->redirectToRoute('admin_liste_documents', ['repo' => $repo]);
        }
        return $this->render('user/demande_document.html.twig', [
            'form' => $form->createView(),
            'titre' => $array['titre'],
        ]);
    }

    /**
     * @Route("/admin/liste/{repo}", name="admin_liste_documents")
     * @Route("/admin/TableauAbsence", name="admin_tableau_absence")
     */
    public function liste_documents($repo = null, DocumentService $docService, Request $request): Response
    {
        $search = null;
        $form = null;
        if (!$repo) {
            $search = new AbsenceSearch();
            $form = $this->createForm(AbsenceSearchType::class, $search);
            $form->handleRequest($request);
            $form = $form->createView();
        }
        if ($repo == 'Personnel') {
            $search = new PersonnelSearch();
            $form = $this->createForm(PersonnelSearchType::class, $search);
            $form->handleRequest($request);
            $form = $form->createView();
        }
        if ($repo == 'Historique') {
            $search = new HistoriqueSearch();
            $form = $this->createForm(HistoriqueSearchType::class, $search);
            $form->handleRequest($request);
            $form = $form->createView();
        }

        return $this->render($docService->getListeDocuments($repo, $request, $search)['twig'], [
            'documents' => $docService->getListeDocuments($repo, $request, $search)['documents'],
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/{repo}/{id}", name="admin_document")
     * @Route("/admin/{repo}/{id}/{etat}/change-statut", name="admin_change_statut")
     */
    public function document($repo, $id, $etat = null, ParametreRepository $parametreRepo, RepositoryService $repoService, DocumentService $docService, EntityManagerInterface $entityManager, Request $request, OrdreMissionRepository $repoOrdre): Response
    {
        $form = null;
        if ($repo == 'OrdreMission') {
            $document = $repoOrdre->find($id);
            $form = $this->createForm(AdminOrdreType::class, null);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $document->setChauffeur($form->get('chauffeur')->getData()->getNomPrenom());
                $document->setTransport($form->get('vehicule')->getData()->getNom() . ' - ' . $form->get('vehicule')->getData()->getMatricule());

                $entityManager->persist($document);
                $entityManager->flush();
                $this->addFlash('success', 'Enregistrement des données avec succès');
                return $this->redirectToRoute('admin_document', ['repo' => 'OrdreMission', 'id' => $id]);
            }
            $form = $form->createView();
        }
        if ($etat) {
            $array = $docService->changeStatut($repo, $id, $etat, $this->getUser());
            return $this->redirectToRoute('admin_liste_documents', ['repo' => $repo]);
        }

        return $this->render($repoService->getRepository($repo)['twig_document'], [
            'document' => $docService->getDocument($repo, $id),
            'parametre' => $parametreRepo->findLastInserted(),
            'form' => $form
        ]);
    }

    /**
     * @Route("/exportpersonnel",  name="exportpersonnel")
     */
    public function exportpersonnel(Service $service)
    {
        $sheet = $service->createSpreadsheet();
        return $this->redirectToRoute('admin_liste_documents', ['repo' => 'Personnel']);
    }
}