<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\GarageRepository;
use App\Repository\CommentsRepository;
use App\Repository\HorairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentsController extends AbstractController
{
    #[Route('/comments', name: 'app_comments')]
    public function index(CommentsRepository $commentsRepository,HorairesRepository $horairesRepository,GarageRepository $garagerepository): Response
    {
        $allComments = $commentsRepository->findAll();
        $horaires = $horairesRepository->findAll();
        $garages = $garagerepository->findAll();
        return $this->render('comments/index.html.twig', [
            'garages' => $garages,
            'horaires'=>$horaires,
            'allComments' => $allComments
        ]);
    }

    #[Route('/comments/new', name: 'app_comments_new', methods: ['GET','POST'])]
    public function new(Request $request,EntityManagerInterface $manager,GarageRepository $garagesRepository,HorairesRepository $horairesRepository,CommentsRepository $commentsRepository): Response
    {
        
        $comments = new Comments();
        $form = $this->createForm(CommentsType::class,$comments);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($comments);
            $manager->flush();
            return $this->redirectToRoute('app_accueil');
        }

        $horaires = $horairesRepository->findAll();
        $garages = $garagesRepository->findAll();
        return $this->render('comments/new.html.twig', [
            'form' => $form->createView(),
            'horaires'=>$horaires,
            'garages' => $garages,
        ]);
    }
}
