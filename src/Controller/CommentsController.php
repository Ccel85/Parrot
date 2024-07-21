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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentsController extends AbstractController
{
    #[Route('/comments', name: 'app_comments')]
    public function index(CommentsRepository $commentsRepository,HorairesRepository $horairesRepository,GarageRepository $garagerepository): Response
    {
        $allComments = $commentsRepository->findBy([], ['isCreatedAt' => 'DESC']);
        $horaires = $horairesRepository->findAll();
        $garages = $garagerepository->findAll();
        
        $formattedComments = [];

        foreach ($allComments as $comment) {
            $formattedComments[] = [
                'comment' => $comment,
                'publicationMessage' => $this->getPublicationMessage($comment->getIsCreatedAt()),
            ];
        }

        return $this->render('comments/index.html.twig', [
            'garages' => $garages,
            'horaires'=>$horaires,
            'formattedComments' => $formattedComments,
            'allComments' => $allComments
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

    #[Route('/comments/delete/{id}', name: 'app_comments_delete',requirements:['id' => '\d+'], methods: ['GET','POST'])]
    public function delete(int $id,EntityManagerInterface $manager,CommentsRepository $commentsRepository,SessionInterface $session): Response
    {
        
        $comment = $commentsRepository->find($id);

    if (!$comment) {
        throw $this->createNotFoundException('Le commentaire n\'existe pas');
    }
    $manager->remove($comment);
    $manager->flush();

    // Ajouter un message flash
    $session->getFlashBag()->add('success', 'Avis supprimé avec succès !');

    return $this->redirectToRoute('app_comments');

    }
}
