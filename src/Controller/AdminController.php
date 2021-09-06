<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Absence;
use App\Entity\Personnel;
use App\Entity\OrdreMission;
use App\Service\StatutService;
use App\Service\PersonnelService;
use App\Form\PersonnelType;
use App\Entity\AttestationTravail;
use App\Repository\PersonnelRepository;

use Doctrine\ORM\EntityManagerInterface;
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
        return $this->render('admin/index.html.twig', [
            'notifications' => $this->notification(),
        ]);
    }


    /**
     * @Route("/admin/liste/{repo}", name="admin_liste_documents")
     */
    public function liste_documents($repo, StatutService $service, Request $request): Response
    {
        return $this->render($service->getListeDocuments($repo, $request)['twig'], [
            'documents' => $service->getListeDocuments($repo, $request)['documents'],
            'notifications' => $this->notification(),
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
            'notifications' => $this->notification(),
        ]);
    }

    /**
     * @Route("/admin/ajout-personnel", name="admin_add_personnel")
     * @Route("/admin/modifier/Personnel/{id}", name="admin_set_personnel")
     */
    public function AddPersonnel(PersonnelService $service, Personnel $personnel = null, $id = null, Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder): Response
    {
        if (!$id) {
            $personnel = new personnel();
        }
        $form = $this->createForm(PersonnelType::class, $personnel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($personnel);

            $entityManager->flush();
            if (!$id) {
                $service->addUser($personnel);
            }
        }
        return $this->render('admin/ajout_personnel.html.twig', [
            'titre' => 'ajout d\'un personnel',
            'form' => $form->createView(),
            'notifications' => $this->notification(),
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

























    /*|***********************************************************************************************|
    |**************************           Notifications                            *******************|
    |***********************************************************************************************|*/

    /*----------------------------------  Notifications ------------------------------------*/
    public function notification()
    {
        $repo = $this->getDoctrine()->getRepository(AttestationTravail::class);
        $attestations_travail = array_merge(
            $repo->findBy(['statut' => 'Nouveau demande']),
            $repo->findBy(['statut' => 'en cours de traitement'])
        );
        $repo = $this->getDoctrine()->getRepository(Absence::class);

        $absences = array_merge(
            $repo->findBy(['statut' => 'Nouveau demande']),
            $repo->findBy(['statut' => 'en cours de traitement'])
        );

        /**
         * Il faut modifier la bd pour avoir le champ ``statut`` puis on decommente ces lignes
         */
        /*$repo = $this->getDoctrine()->getRepository(Fiche::class);
        $fiches = array_merge($repo->findBy(['statut' => 'Nouveau demande']),
                              $repo->findBy(['statut' => 'en cours de traitement']));
        */

        $repo = $this->getDoctrine()->getRepository(OrdreMission::class);
        $ordres = array_merge(
            $repo->findBy(['statut' => 'Nouveau demande']),
            $repo->findBy(['statut' => 'en cours de traitement'])
        );

        $notifications = [
            'attestations_travail' => count($attestations_travail),
            'absences' => count($absences),
            //'fiches' => count($fiches),
            'ordres' => count($ordres)
        ];

        return $notifications;
    }
    /*---------------------------------------------------------------------------------------*/
    /*-------------------------  Partie qui concerne Ajax -----------------------------------*/
    /*---------------------------------------------------------------------------------------*/
    /**
     * @Route("/notifications", name="notifications")
     * 
     * @return Response
     */
    public function notifications(): Response
    {
        return $this->json([
            'code' => 200,
            'message' => 'vous avez des nouveaux demandes!',
            'attestations_travail' => $this->notification()['attestations_travail'],
            'absences' =>  $this->notification()['absences'],
            //'fiches' => count($fiches),
            'ordres' => $this->notification()['ordres']

        ], 200);
    }
}