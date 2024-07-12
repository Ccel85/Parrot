<?php

namespace App\Controller;

use App\Repository\GarageRepository;
use App\Repository\HorairesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil', methods: ['GET'])]
    public function index(GarageRepository $garagesRepository,HorairesRepository $horairesRepository): Response
    {
        $horaires = $horairesRepository->findAll();
        $garages = $garagesRepository->findAll();
        return $this->render('accueil/index.html.twig',[
            'garages'=>$garages,
            'horaires'=>$horaires,
        ]);
    }
}

