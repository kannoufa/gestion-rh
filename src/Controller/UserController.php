<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Service\FormService;
use App\Service\DocumentService;
use App\Service\RepositoryService;
use App\Service\Service;
use App\Entity\OrdreMission;
use App\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{
    /**
     * @Route("/", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', []);
    }

    /**
     * @Route("/user/delete/{repo}/{id}", name="user_delete")
     */
    public function delete($repo, $id, DocumentService $docservice): Response
    {
        $docservice->changeStatut($repo, $id, 'Refusé');
        return $this->redirectToRoute('user');
    }


    /**
     * @Route("/user/demande/{repo}", name="user_demande_document")
     */
    public function demande_document($repo, FormService $formService, RepositoryService $repoService, Request $request, SluggerInterface $slugger): Response
    {
        $array = $repoService->getRepository($repo);
        $form = $this->createForm($array['type'], $array['document']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tab = null;
            if ($repo == 'Absence')
                $array['document']->setCause(Absence::CAUSE[$form->get('cause')->getData()]);

            if ($repo == 'AttestationSalaire') {
                $tab = [
                    'type' => $form->get('type')->getData(),
                    'autre' => $request->get('autre')
                ];
            }

            if ($repo == 'OrdreMission') {
                $array['document']->setFrais(OrdreMission::FRAIS[$form->get('frais')->getData()]);

                $tab = [
                    'transport' => $request->get("transport"),
                    'matricule' => $request->get("matricule")
                ];
            }

            $this->addFlash('success', $formService->registerForm($array['document'], $this->getUser(), $repo, $tab));
            return $this->redirectToRoute('user_demande_document', ['repo' => $repo]);
        }
        return $this->render('user/demande_document.html.twig', [
            'form' => $form->createView(),
            'titre' => $array['titre'],
        ]);
    }

    /**
     * @Route("/user/profil", name="user_profil")
     */
    public function profil(): Response
    {
        return $this->render('user/profil.html.twig', [
            'document' => $this->getUser()->getPersonnel(),
        ]);
    }

    /**
     * @Route("/user/historique", name="user_historique")
     * @Route("/user/historique/{repo}/{id}", name="user_historique_document")
     */
    public function Historique(Service $service, Request $request): Response
    {
        return $this->render('user/historique.html.twig', [
            'documents' => $service->getHistoryUser($this->getUser()->getPersonnel()->getId(), $request),
        ]);
    }

    /**
     * @Route("/user/validation/{repo}/{id}/{idMsg}", name="user_document")
     * @Route("/user/validation/{repo}/{id}/{etat}/change-statut", name="user_change_statut")
     */
    public function document($repo, $id, $idMsg = null, $etat = null, DocumentService $docService, MessageRepository $msgRepo, RepositoryService $repoService): Response
    {
        if ($etat) {
            $array = $docService->changeStatut($repo, $id, $etat, $this->getUser());
            return $this->redirectToRoute('message');
        } else {
            $message = $msgRepo->find($idMsg);
            if ($message->getIsRead() == false) {
                $message->setIsRead(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($message);
                $em->flush();
            }
        }
        return $this->render($repoService->getRepository($repo)['twig_validation'], [
            'document' => $docService->getDocument($repo, $id),
        ]);
    }
}