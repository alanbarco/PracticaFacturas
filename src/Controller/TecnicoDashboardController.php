<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TecnicoTicketType;
use App\Repository\TicketRepository;
use App\Repository\TipoRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TecnicoDashboardController extends AbstractController
{
    #[Route('/tecnico/dashboard', name: 'app_tecnico_dashboard')]
    public function index(TicketRepository $ticketRepo): Response
    {
        $tickets = $ticketRepo->findAll();
        return $this->render('tecnico_dashboard/index.html.twig', [
            'lista' => $tickets,
        ]);
    }

    #[Route('/tecnico/ticket/revisar/{id}', name: 'app_tecnico_ticket')]
    public function revisar(Request $request, ManagerRegistry $doctrine, Ticket $ticket, TipoRepository $tipoRepo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_TECNICO');
        $tipos = $tipoRepo->findAll();
        $form = $this->createForm(TecnicoTicketType::class, $ticket, ['arrayTipos'=> $tipos]);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $tipo = $form['tipo']->getData();
            $ticket->setIdTipo($tipo);
            $ticket= $form->getData();
            $em = $doctrine->getManager(); //objeto que administra las entidades y BD
            $em->persist($ticket);
            $em->flush();
            return $this->redirectToRoute('app_tecnico_dashboard');
        }
        return $this->render('tecnico_dashboard/revisar.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}
