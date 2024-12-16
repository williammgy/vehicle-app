<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Vehicle;

use App\Form\VehicleType;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/vehicles', name: 'vehicle_')]
class VehicleController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    #[Route('/create', name: 'creation', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $vehicle = new Vehicle;

        $form = $this->createForm(VehicleType::class, $vehicle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($vehicle);
            $this->entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('create_vehicle.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/update', name: 'update', methods: ['GET', 'POST'])]
    public function update(Request $request, Vehicle $vehicle): Response
    {
        $form = $this->createForm(VehicleType::class, $vehicle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('update_vehicle.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/delete', name: 'deletion', methods: ['POST'])]
    public function delete(Request $request, Vehicle $vehicle): Response
    {
        if ($this->isCsrfTokenValid(
            'delete' . $vehicle->getId(), $request->request->get('_token')
        )) {
            $this->entityManager->remove($vehicle);
            $this->entityManager->flush();
    
            $this->addFlash('success', 'The vehicule has been deleted.');
        } else {
            $this->addFlash('error', 'Invalid CSRF token.');
        }
    
        return $this->redirectToRoute('home');
    }
}