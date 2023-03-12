<?php

namespace App\Controller;

use App\Entity\Factura;
use App\Entity\Ticket;
use App\Form\FacturaFormType;
use App\Repository\FacturaRepository;
use App\Repository\TicketRepository;
use App\Repository\TipoRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FacturacionDashboardController extends AbstractController
{
    #[Route('/facturacion/dashboard', name: 'app_facturacion_dashboard')]
    public function index(FacturaRepository $facturaRepo): Response
    {
        $facturas = $facturaRepo->findAll();
        
        return $this->render('facturacion_dashboard/index.html.twig', [
            'lista' => $facturas,
        ]);
    }



    #[Route('/facturacion/tickets', name: 'app_facturacion_tickets')]
    public function tickets(TicketRepository $ticketRepo): Response
    {
        $tickets = $ticketRepo->findBy(['estado'=>'A']);
        
        return $this->render('facturacion_dashboard/tickets.html.twig', [
            'lista' => $tickets,
        ]);
    }





    #[Route('/facturacion/revisar/{id}', name: 'app_facturacion_revisar')]
    public function revisar(Request $request, ManagerRegistry $doctrine, Ticket $ticket): Response
    {
        $usuario = $ticket->getIdUsuario();
        $idTicket = $ticket->getIdTicket();
        $descripcion = $ticket->getDescripcion();
        $horasInv = $ticket->getHorasInv();
        $tipoTrabajo = $ticket->getIdTipo()->getDescripcion();
        $valorHora= $ticket->getIdTipo()->getValorhora();
        $this->denyAccessUnlessGranted('ROLE_FACTURACION');
        $factura = new Factura();
        $form = $this->createForm(FacturaFormType::class, $factura);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){

            $factura->setIdTicket($ticket);
            $factura->setIdUsuario($usuario);
            $factura->setEstado('A');
            $ticket->setEstado('I');
            $factura= $form->getData();
            $em = $doctrine->getManager();
            $em->persist($factura);
            $em->flush();
            return $this->redirectToRoute('app_facturacion_dashboard');
        }
        return $this->render('facturacion_dashboard/revisarTickets.html.twig', [
            'form'=>$form->createView(),
            'descripcion'=>$descripcion,
            'horasInv'=>$horasInv,
            'tipoTrabajo'=>$tipoTrabajo,
            'valorHora'=>$valorHora,
            'idTicket'=>$idTicket
        ]);
    }

}
