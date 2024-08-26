<?php

namespace App\Controller\Admin;

use App\Entity\Messages;
use App\Repository\GarageRepository;
use App\Repository\HorairesRepository;
use App\Repository\MessagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessagesController extends AbstractController
{
    #[Route('/admin/messages', name: 'app_admin_messages')]
    public function adminIndex(MessagesRepository $messageRepository,HorairesRepository $horairesRepository,GarageRepository $garageRepository): Response
    {
        $messagesNonArchives = $messageRepository->findBy(['isArchived' => false]);
        $messagesArchives = $messageRepository->findBy(['isArchived' => true]);
        $garages = $garageRepository->findAll();
        $horaires = $horairesRepository->findAll();

        return $this->render('admin/messages/index.html.twig', [
            'messagesnonarchives' => $messagesNonArchives,
            'messagesarchives' => $messagesArchives,
            'garages' => $garages,
            'horaires'=>$horaires,
        ]);
    }

    #[Route('/admin/messages/{id}', name: 'app_admin_messages_show',requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Messages $message,HorairesRepository $horaires,GarageRepository $garages): Response
    {
        {
            return $this->render('admin/messages/show.html.twig', [
                'message' => $message,
                'garages' => $garages,
                'horaires'=>$horaires,
            ]);
        }
    }

    #[Route('/messages/archive', name: 'app_messages_archive', methods: ['POST'])]
    public function archiveMessages(Request $request, MessagesRepository $messageRepository, EntityManagerInterface $entityManager): Response
{
    // Récupère les IDs des messages cochés dans le formulaire
    $selectedIds = $request->request->all('checkboxArchive', []);

    // Parcourt chaque ID à archiver
    if (!empty($selectedIds)) {
        // Trouve le message correspondant à l'ID dans le repository
        $messages = $messageRepository->findBy(['id' => $selectedIds]);

        // Si un message est trouvé, on le marque comme archivé
            foreach ($messages as $message) {
                $message->setIsArchived(true);
                $entityManager->persist($message);
            }
            // Applique toutes les modifications à la base de données
            $entityManager->flush();

    // Ajoute un message flash pour informer l'utilisateur que l'archivage a réussi
    $this->addFlash('success', 'Messages archivés avec succès.');
    }

    //si le bouton delete est selectionner:
    if ($request->request->has('desarchiver')) {

        $selectedIdsNonarchive = $request->request->all('checkboxDesarchive', []);
        if (!empty($selectedIdsNonarchive)) {
        // Trouve le message correspondant à l'ID dans le repository
        $messages = $messageRepository->findBy(['id' => $selectedIdsNonarchive]);

        foreach ($messages as $message) {
            $message->setIsArchived(false);
            $entityManager->persist($message);
        }
        $entityManager->flush();
    // Ajoute un message flash pour informer l'utilisateur que l'archivage a réussi
        $this->addFlash('success', 'Messages désarchivés avec succès.');

        }
    }
    //si le bouton delete est selectionner:
    if ($request->request->has('delete')) {

        $selectedIdsNonarchive = $request->request->all('checkboxDesarchive', []);
        if (!empty($selectedIdsNonarchive)) {
        // Trouve le message correspondant à l'ID dans le repository
        $messages = $messageRepository->findBy(['id' => $selectedIdsNonarchive]);

        foreach ($messages as $message) {
            $entityManager->remove($message);
        }
        $entityManager->flush();
    // Ajoute un message flash pour informer l'utilisateur que l'archivage a réussi
        $this->addFlash('success', 'Messages supprimés avec succès.');

        }
    }
        // Redirige l'utilisateur vers la route 'app_messages' après l'archivage
        return $this->redirectToRoute('app_admin_messages');
    }
}

   /* #[Route('/messages/unarchive', name: 'app_messages_unarchive', methods: ['POST'])]
    public function unarchiveMessages(Request $request,MessagesRepository $messages, EntityManagerInterface $entityManager): Response
    {
        $unarchiveEmails = $request->request->get('unarchive', []);

        foreach ($unarchiveEmails as $email) {
            $message = $messages->findOneBy(['email' => $email]);
            if ($message) {
                $message->setIsArchived(false);
                $entityManager->persist($message);
            }
        }

        $entityManager->flush();

        $this->addFlash('success', 'Messages désarchivés avec succès.');

        return $this->redirectToRoute('app_messages');
    }*/

