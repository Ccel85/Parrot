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
        
        $message = new Messages();
        $form = $this->createForm(MessagesType::class,$message);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($message);
            $manager->flush();

            return $this->redirectToRoute('app_messages_new');
        }
        $messages = $messagerepository->findAll();
        $garages = $garagerepository->findAll();
        $horaires = $horairesRepository->findAll();
        return $this->render('messages/new.html.twig', [
            'form' => $form,
            'messages' => $messages,
            'garages' => $garages,
            'horaires'=>$horaires,

        ]);
    }
}
