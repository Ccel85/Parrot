<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\GarageRepository;
use App\Repository\HorairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin/user')]

class RegistrationController extends AbstractController
{
    #[Route('/new', name: 'app_admin_user_new')]
    public function register(Request $request,HorairesRepository $horairesRepository,GarageRepository $garagerepository, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // Ajoute un message flash pour informer l'utilisateur que l'archivage a réussi
        $this->addFlash('success', 'Utilisateur ajouté avec succès.');

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_admin_dashboard');
        }
        
        $garages = $garagerepository->findAll();
        $horaires = $horairesRepository->findAll();
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
            'garages' => $garages,
            'horaires'=>$horaires,
        ]);
    }
}
