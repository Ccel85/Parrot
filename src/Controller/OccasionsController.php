<?php

namespace App\Controller;

use App\Repository\GarageRepository;
use App\Repository\AnnoncesRepository;
use App\Repository\HorairesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OccasionsController extends AbstractController
{
    #[Route('/occasions', name: 'app_occasions_index')]
    public function index(AnnoncesRepository $annoncesrepository,HorairesRepository $horairesRepository,GarageRepository $garagerepository): Response
    {
        $occasions = $annoncesrepository->findAll();
        $garages = $garagerepository->findAll();
        $horaires = $horairesRepository->findAll();
        return $this->render('occasions/index.html.twig', [
            'occasions' => $occasions,
            'garages' => $garages,
            'horaires'=>$horaires,

        ]);
    }
}
