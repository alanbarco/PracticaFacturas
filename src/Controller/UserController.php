<?php

namespace App\Controller;

use App\Repository\FacturaRepository;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/cliente', name: 'app_user')]
    public function index(FacturaRepository $factRepo): Response
    {
        $usuario = $this->getUser();
        $facturas = $factRepo->findBy(['idUsuario'=>$usuario]);
        $this->denyAccessUnlessGranted('ROLE_CLIENTE');
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'lista'=> $facturas
        ]);
    }
    #[Route('/cliente/tickets', name: 'app_cliente_tickets')]
    public function listar(TicketRepository $ticketRepo): Response
    {
        $usuario = $this->getUser();
        $tickets = $ticketRepo->findBy(['idUsuario'=>$usuario]);
        $this->denyAccessUnlessGranted('ROLE_CLIENTE');
        return $this->render('user/tickets.html.twig', [
            'controller_name' => 'UserController',
            'lista'=> $tickets
        ]);
    }
}
