<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\VehicleFiltersType;
use App\Repository\TypeRepository;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        TypeRepository $typeRepository,
        VehicleRepository $vehicleRepository
    ): Response {
        $filters = $request->getSession()->get('filters', [
            'brand' => '',
            'type' => null,
            'seats_amount' => '',
        ]);

        if (!empty($filters['type'])) {
            $filters['type'] = $typeRepository->find($filters['type']);
        }

        $form = $this->createForm(VehicleFiltersType::class, null, [
            'data' => $filters
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filters = $form->getData();
            $request->getSession()->set('filters', $filters);
        }

        $types = $typeRepository->findBy([], [
            'id' => 'ASC',
        ]);

        $page = $request->query->getInt('page', 1);

        $vehicles = $vehicleRepository->findWithFilters(
            $filters,
            $page,
            15
        );

        return $this->render('index.html.twig', [
            'types' => $types,
            'vehicles' => $vehicles,
            'vehicles_amount' => count($vehicleRepository->findAll()),
            'filters' => $filters,
            'form' => $form->createView(),
            'page' => $page,
            'total_pages' => ceil($vehicles->count() / 15),
        ]);
    }

    #[Route('/reset-filters', name: 'filters_reset')]
    public function resetFilters(Request $request): RedirectResponse
    {
        $request->getSession()->remove('filters');

        return $this->redirectToRoute('home');
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error]
        );
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
