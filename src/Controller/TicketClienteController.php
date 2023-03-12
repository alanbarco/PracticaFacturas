<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketClienteType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketClienteController extends AbstractController
{
    #[Route('/cliente/ticket', name: 'app_ticket_cliente')]
    public function index(Request $request,ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('ROLE_CLIENTE');
        $ticket= new Ticket();
        $usuario = $this->getUser();
        $form = $this->createForm(TicketClienteType::class, $ticket);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $ticket->setIdUsuario($usuario);
            $ticket->setEstado('A');
            $em = $doctrine->getManager();
            $em->persist($ticket);
            $em->flush();
            return $this->redirectToRoute('app_user');
        }
        return $this->render('ticket_cliente/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
