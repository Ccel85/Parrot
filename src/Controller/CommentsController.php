<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsType;
use Psr\Log\LoggerInterface;
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
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    #[Route('/comments', name: 'app_comments')]
public function index(CommentsRepository $commentsRepository, HorairesRepository $horairesRepository, GarageRepository $garagerepository): Response
{

    // récuperer les données
    $commentsNotArchived = $commentsRepository->findBy(['isArchived' => false]);
    $commentsArchived = $commentsRepository->findBy(['isArchived' => true]);
    $horaires = $horairesRepository->findAll();
    $garages = $garagerepository->findAll();
    // preparer les tableaux de commentaires
    $formattedComments = [];
    $formattedCommentsArchived = [];

    // formater les commentaires non-archives
    foreach ($commentsNotArchived as $comment) {
        $formattedComments[] = [
            'comment' => $comment,
            'publicationMessage' => $this->getPublicationMessage($comment->getIsCreatedAt()),
        ];
    }

    // formater les commentaires archives
    foreach ($commentsArchived as $commentArchived) {
        $formattedCommentsArchived[] = [
            'comment' => $commentArchived,
            'publicationMessage' => $this->getPublicationMessage($commentArchived->getIsCreatedAt()),
        ];
    }
    // rendre la vue
    return $this->render('comments/index.html.twig', [
        'garages' => $garages,
        'horaires' => $horaires,
        'formattedComments' => $formattedComments,
        'formattedCommentsArchived' => $formattedCommentsArchived,
        'commentsNotArchived' => $commentsNotArchived,
        'commentsArchived' => $commentsArchived,
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
    
//Route pour gestion des checkboxs
#[Route('/comments/manage', name: 'app_comments_manage', methods: ['POST'])]
public function manage(Request $request, EntityManagerInterface $manager, CommentsRepository $commentsRepository): Response
{
    $selectedIds = $request->request->all('checkbox', []);

    if (!empty($selectedIds)) {
        $comments = $commentsRepository->findBy(['id' => $selectedIds]);
    //si le bouton archive est selectionner:
        if ($request->request->has('archive')) {
            foreach ($comments as $comment) {
                $comment->setIsArchived(true);
                $manager->persist($comment);
            }
            $manager->flush();
            $this->addFlash('success', 'Commentaires archivés avec succès !');
        }
        //si le bouton delete est selectionner:
        if ($request->request->has('delete')) {
            foreach ($comments as $comment) {
                $manager->remove($comment);
            }
            $manager->flush();
            $this->addFlash('success', 'Commentaires supprimés avec succès !');
        }
    } else {
        $this->addFlash('error', 'Aucun commentaire sélectionné.');
    }

    return $this->redirectToRoute('app_comments');
}
}
