<?php

namespace App\Controller;

use Pusher\Pusher;
use App\Service\FormService;
use App\Service\StatutService;
use App\Entity\AttestationSalaire;
use App\Service\HistoriqueService;
use App\Form\DemandeValidationType;
use App\Repository\PersonnelRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


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
    public function demande_document($repo, FormService $service, Request $request, SluggerInterface $slugger): Response
    {
        $array = $service->getRepository($repo);
        $form = $this->createForm($array['type'], $array['document']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($repo == 'Absence') {
                $brochureFile = $form->get('brochure')->getData();


                if ($brochureFile) {
                    $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);

                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                    try {
                        $brochureFile->move(
                            $this->getParameter('brochures_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                    }


                    //$document->setBrochureFilename($newFilename);
                }
            }

            if ($repo == 'OrdreMission') {
                $brochureFile = $form->get('brochure')->getData();

                if ($brochureFile) {
                    $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);

                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                    try {
                        $brochureFile->move(
                            $this->getParameter('brochures_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                    }


                    // $document->setBrochureFilename($newFilename);
                }
            }
            $tab = [];
            if ($repo == 'OrdreMission') $tab = ['transport' => $request->get("transport"), 'matricule' => $request->get("matricule")];
            $this->addFlash('success', $service->registerForm($array['document'], $this->getUser(), $repo, $tab));
            return $this->redirectToRoute('user_demande_document', ['repo' => $repo]);
        }
        return $this->render('user/demande_document.html.twig', [
            'user' => 'user',
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

    /**
     * @Route("/user/validation/{repo}/{id}", name="user_document")
     * @Route("/user/validation/{repo}/{id}/{etat}/change-statut", name="user_change_statut")
     */
    public function document($repo, $id, $etat = null, StatutService $service): Response
    {
        if ($etat) {
            $array = $service->changeStatut($repo, $id, $etat);
            $this->addFlash('success', 'Enregistrer avec succès');
            return $this->redirectToRoute('user_document', ['repo' => $repo, 'id' => $id]);
        }

        return $this->render($service->getRepository($repo)['twig_validation'], [
            'document' => $service->getDocument($repo, $id),
        ]);
    }
    public function getType()
    {
        $type = AttestationSalaire::TYPE;
        $output = [];
        foreach ($type as $key => $value) {
            $output[$key] = $value;
        }
        return $output;
    }
}