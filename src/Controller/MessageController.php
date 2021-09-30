<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="message")
     */
    public function index(Request $request, PaginatorInterface $paginator, MessageRepository $repo): Response
    {
        $messages = $paginator->paginate(
            $repo->findAllVisibleQuery($this->getUser()->getId()),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('message/index.html.twig', [
            'messages' => $messages,
        ]);
    }

    /**
     * @Route("/send", name="send")
     */
    public function send(Request $request): Response
    {
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
        ]);
    }

    /**
     * @Route("/read/{id}", name="read")
     */
    public function read(Message $message): Response
    {
        if ($message->getIsRead() == false) {
            $message->setIsRead(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
        }

        return $this->render('message/read.html.twig', compact("message"));
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
}