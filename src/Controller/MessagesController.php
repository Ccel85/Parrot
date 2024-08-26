<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Form\MessagesType;
use App\Repository\GarageRepository;
use App\Repository\HorairesRepository;
use App\Repository\MessagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/messages')]
//message page contact
class MessagesController extends AbstractController
{
    #[Route('/new', name: 'app_messages_new' , methods: ['GET' , 'POST'])]
    public function new(Request $request,EntityManagerInterface $manager,HorairesRepository $horairesRepository,MessagesRepository $messagerepository,GarageRepository $garagerepository): Response
    {
        // Récupérer le paramètre "subject" de l'URL
    $subject = $request->query->get('subject', ''); // Valeur par défaut vide si non fourni
    $message = new Messages();
    $formOptions = [];

    if ($subject) {
        // Pré-remplir le champ "subject" du formulaire
        $message->setSubject($subject);
          // Ajouter l'option pour rendre le champ "subject" non modifiable
        $formOptions['subject_readonly'] = true;
    }
        $form = $this->createForm(MessagesType::class,$message,$formOptions);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($message);
            $manager->flush();

            // Ajoute un message flash pour informer l'utilisateur que l'archivage a réussi
        $this->addFlash('success','Le message a bien été envoyé, nous vous répondrons rapidement!');

        return $this->redirectToRoute('app_messages_new');
        }
        
        $messages = $messagerepository->findAll();
        $garages = $garagerepository->findAll();
        $horaires = $horairesRepository->findAll();
        return $this->render('messages/new.html.twig', [
            'form' => $form->createView(),
            'messages' => $messages,
            'garages' => $garages,
            'horaires'=>$horaires,
            'subject' => $subject,

        ]);
    }
}
