<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Absence;
use App\Entity\Personnel;
use App\Form\PersonnelType;
use App\Entity\OrdreMission;
use App\Service\FormService;
use App\Entity\AbsenceSearch;
use App\Form\DepartementType;
use App\Service\StatutService;
use App\Form\AbsenceSearchType;
use App\Service\PersonnelService;
use App\Entity\AttestationTravail;
use App\Entity\DepartementService;
use App\Entity\EnregistrementEntree;
use App\Form\EnregistrementEntreeType;
use App\Repository\PersonnelRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OrdreMissionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', []);
    }


    /**
     * @Route("/admin/liste/{repo}", name="admin_liste_documents")
     * @Route("/admin/TableauAbsence", name="admin_tableau_absence")
     */
    public function liste_documents($repo = null, StatutService $service, Request $request): Response
    {
        $search = null;
        $form = null;
        if (!$repo) {
            $search = new AbsenceSearch();
            $form = $this->createForm(AbsenceSearchType::class, $search);
            $form->handleRequest($request);
            $form = $form->createView();
        }
        return $this->render($service->getListeDocuments($repo, $request, $search)['twig'], [
            'documents' => $service->getListeDocuments($repo, $request, $search)['documents'],
            'form' => $form
        ]);
    }

    /**
     * @Route("/admin/{repo}/{id}", name="admin_document")
     * @Route("/admin/{repo}/{id}/{etat}/change-statut", name="admin_change_statut")
     */
    public function document($repo, $id, $etat = null, StatutService $service): Response
    {

        if ($etat) {
            $array = $service->changeStatut($repo, $id, $etat);
            return $this->redirectToRoute('admin_liste_documents', ['repo' => $repo]);
        }

        return $this->render($service->getRepository($repo)['twig_document'], [
            'document' => $service->getDocument($repo, $id),
        ]);
    }

    /**
     * @Route("/admin/ajout-personnel", name="admin_add_personnel")
     * @Route("/admin/modifier/Personnel/{id}", name="admin_set_personnel")
     */
    public function AddPersonnel(PersonnelService $service, Personnel $personnel = null, $id = null, Request $request, PersonnelRepository $repo, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder): Response
    {
        $titre = 'Modification des données';
        if (!$id) {
            $personnel = new personnel();
            $titre = 'ajout d\'un personnel';
        }
        $form = $this->createForm(PersonnelType::class, $personnel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($personnel);

            $entityManager->flush();
            if (!$id) {
                $service->addUser($personnel);
            }

            $this->addFlash('success', 'Enregistrement des données avec succès');
        }
        return $this->render('admin/ajout_personnel.html.twig', [
            'titre' => $titre,
            'form' => $form->createView(),
            'personnel' => $repo->findLastInserted(),
            'editMode' => $personnel->getId() !== null
        ]);
    }


    /**
     *  @Route("/admin/supprimer/Personnel/{id}", name="admin_delete_personnel")
     */
    public function deletePersonnel($id, PersonnelService $service)
    {
        $service->delete($id);
        return $this->redirectToRoute('admin_liste_documents', ['repo' => 'Personnel']);
    }

    /**
     * @Route("/admin/ajout-departement-service", name="admin_add_departement")
     * @Route("/admin/modifier/departement/{id}", name="admin_set_departement")
     */
    public function addDepartement($id, Request $request, DepartementService $departement = null, EntityManagerInterface $entityManager): Response
    {
        if (!$id) {
            $departement = new DepartementService();
        }
        $form = $this->createForm(DepartementType::class, $departement);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($departement);
            $entityManager->flush();
            $this->addFlash('success', 'L\'ajout du département/service a été fait avec succès');
        }

        return $this->render('user/demande_document.html.twig', [
            'titre' => 'ajout d\'un département ou service',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/remplissage/PV/{id}", name="admin_PV")
     */
    public function PV($id, FormService $service, Request $request): Response
    {
        $array = $service->getRepository('EnregistrementEntree');
        $form = $this->createForm($array['type'], $array['document']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', $service->registerForm($array['document'], $id, 'EnregistrementEntree', []));
            return $this->redirectToRoute('admin_add_personnel');
        }

        return $this->render('user/demande_document.html.twig', [
            'titre' => 'Remplissage de PV',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/OrdreMission/setCauffeur/{id}", name="admin_setChauffeur")
     */
    public function setChauffeurOrdre($id, OrdreMissionRepository $repo, Request $request, EntityManagerInterface $entityManager): Response
    {
        $document = $repo->find($id);

        $document->setChauffeur($request->get('chauffeur'));

        $entityManager->persist($document);
        $entityManager->flush();
        return $this->redirectToRoute('admin_document', ['repo' => 'OrdreMission', 'id' => $id]);
    }
}