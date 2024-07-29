<?php

namespace App\Controller;

use App\Repository\GarageRepository;
use App\Repository\HorairesRepository;
use App\Repository\ServicesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/services')]
class ServicesController extends AbstractController
{
    #[Route('', name: 'app_services_index')]
    public function index(ServicesRepository $servicesrepository,HorairesRepository $horairesRepository,GarageRepository $garagerepository): Response
    {
        $services = $servicesrepository->findBy(['isPublished' => 'false']);
        $garages = $garagerepository->findAll();
        $horaires = $horairesRepository->findAll();
        return $this->render('services/index.html.twig', [
            'services' => $services,
            'garages'=>$garages,
            'horaires'=>$horaires,

        ]);
    }
}
