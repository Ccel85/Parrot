<?php

namespace App\Controller\Admin;

use App\Entity\Horaires;
use App\Form\HorairesType;
use App\Repository\GarageRepository;
use App\Repository\HorairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/horaires')]
class HorairesController extends AbstractController
{
    #[Route('/', name: 'app_admin_horaires', methods: ['GET', 'POST'])]
    public function index(Request $request, HorairesRepository $horairesRepository, GarageRepository $garagesRepository, EntityManagerInterface $manager): Response
    {
        $horaires = $horairesRepository->findAll();
        $form = $this->createForm(HorairesType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $jour = $data->getJoursOuverture();

            // Recherche si un horaire pour ce jour existe déjà
            $existingHoraire = $horairesRepository->findOneBy(['joursOuverture' => $jour]);

            if ($existingHoraire) {
                // Mise à jour de l'horaire existant
                $existingHoraire->setHeuresDebutAm($data->getHeuresDebutAm());
                $existingHoraire->setHeuresFinAm($data->getHeuresFinAm());
                $existingHoraire->setHeuresDebutPm($data->getHeuresDebutPm());
                $existingHoraire->setHeuresFinPm($data->getHeuresFinPm());
                $manager->persist($existingHoraire);
            } else {
                // Création d'un nouvel horaire
                $manager->persist($data);
            }

            $manager->flush();

            // Redirige vers la route principale des horaires après soumission du formulaire
            return $this->redirectToRoute('app_admin_horaires');
        }

        // Rend la vue avec le formulaire
            $garages = $garagesRepository->findAll();

            return $this->render('admin/horaires/index.html.twig', [
                'horaires' => $horaires,
                'form' => $form->createView(),
                'garages' => $garages,
        ]);
    }
}



