<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Form\MessageType;
use App\Repository\PersonnelRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="message")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
            'users' => $users,

        ]);
    }

    /**
     * @Route("/send", name="send")
     */
    public function send(Request $request): Response
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();
        $message = new Message;
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($this->getUser());
            $message->setCreatedAt(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->addFlash("message", "Message envoyé avec succès.");
            return $this->redirectToRoute("message");
        }

        return $this->render("message/send.html.twig", [
            "form" => $form->createView(),
            'controller_name' => 'MessageController',
            'users' => $users,
        ]);
    }

    /**
     * @Route("/received", name="received")
     */
    public function received(): Response
    {
        return $this->render('message/received.html.twig');
    }


    /**
     * @Route("/sent", name="sent")
     */
    public function sent(): Response

    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();
        return $this->render('message/sent.html.twig', [
            'controller_name' => 'MessageController',
            'users' => $users,

        ]);
    }

    /**
     * @Route("/sent/demande-fiche/{id}", name="remplir_fiche")
     */
    public function sentFiche($id, UserRepository $repo): Response

    {
        $recipient = $repo->findOneBy(
            ['personnel' => $id]
        );
        $message = new Message();
        $message->setTitle('Demande de remplir la fiche de renseignement');
        $message->setMessage('');
        $message->setSender($this->getUser());
        $message->setRecipient($recipient);
        $message->setCreatedAt(new \DateTime());
        $em = $this->getDoctrine()->getManager();

        $this->addFlash('success', 'Un message est envoyé à Mr/Madame ' . $recipient->getUsername() . ' pour remplir la fiche');

        $em->persist($message);
        $em->flush();

        return $this->redirectToRoute("admin_add_personnel");
    }


    /**
     * @Route("/read/{id}", name="read")
     */
    public function read(Message $message): Response
    {

        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        return $this->render('message/read.html.twig', compact("message"));
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Message $message): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute("sent");
    }
    /**
     * @Route("/delet/{id}", name="delet")
     */
    public function delet(Message $message): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute("message");
    }


    /**
     * @Route("/deletee/{id}", name="deletee")
     */
    public function deletee(Message $message): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute("message");
    }
}