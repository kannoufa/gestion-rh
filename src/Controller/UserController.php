<?php

namespace App\Controller;

use Pusher\Pusher;
use App\Service\FormService;
use App\Service\StatutService;
use App\Service\HistoriqueService;
use App\Repository\PersonnelRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', []);
    }


    /**
     * @Route("/user/demande/{repo}", name="user_demande_document")
     */
    public function demande_document($repo, FormService $service, Request $request): Response
    {
        $array = $service->getRepository($repo);
        $form = $this->createForm($array['type'], $array['document']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', $service->registerForm($array['document'], $this->getUser(), $repo));
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
    public function Historique(HistoriqueService $service, Request $request): Response
    {
        return $this->render('user/historique.html.twig', [
            'documents' => $service->getHistoryUser($this->getUser()->getPersonnel()->getId(), $request),
        ]);
    }

    /**
     * @Route("/notification", name="notification", methods={"POST"})
     */
    public function notifi(Pusher $pusher, $repo, StatutService $service): Response
    {
        $pusher->trigger('greetings', 'new-greeting', []);
        return new Response();
    }
}