<?php

namespace App\Controller;

use App\Repository\GarageRepository;
use App\Repository\CommentsRepository;
use App\Repository\HorairesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil', methods: ['GET'])]

        public function index(CommentsRepository $commentsRepository, GarageRepository $garagesRepository, HorairesRepository $horairesRepository): Response
    {
        $lastBestComments = $commentsRepository->lastBestComments();
        $formattedComments = [];

        foreach ($lastBestComments as $comment) {
            $formattedComments[] = [
                'comment' => $comment,
                'publicationMessage' => $this->getPublicationMessage($comment->getIsCreatedAt()),
            ];
        }

        $horaires = $horairesRepository->findAll();
        $garages = $garagesRepository->findAll();

        return $this->render('accueil/index.html.twig', [
            'garages' => $garages,
            'horaires' => $horaires,
            'formattedComments' => $formattedComments,
            'lastBestComments' => $lastBestComments
        ]);
    }
    
    private function getPublicationMessage(\DateTimeImmutable $date): string
    {
        $datePublication = $date->getTimestamp();
        $dateActuelle = time();
        $diffEnJours = floor(($dateActuelle - $datePublication) / (60 * 60 * 24));
        $diffEnSemaines = floor($diffEnJours / 7);

        if ($diffEnJours == 0) {
            return "Publié aujourd'hui";
        } elseif ($diffEnJours == 1) {
            return "Publié hier";
        } elseif ($diffEnJours < 7) {
            return "Publié il y a " . $diffEnJours . " jours";
        } elseif ($diffEnSemaines == 1) {
            return "Publié il y a 1 semaine";
        } else {
            return "Publié il y a " . $diffEnSemaines . " semaines";
        }
    }
}

