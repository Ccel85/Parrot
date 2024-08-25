<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\Services;
use App\Form\ServicesType;
use App\Repository\GarageRepository;
use App\Repository\HorairesRepository;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/services')]
class ServicesController extends AbstractController
{
    #[Route('/', name: 'app_admin_services_show')]
    public function index(ServicesRepository $repository,GarageRepository $garagesRepository,HorairesRepository $horairesRepository,  ): Response
    {
        $services = $repository->findAll();
        $horaires = $horairesRepository->findAll();
        $garages = $garagesRepository->findAll();
        return $this->render('admin/services/show.html.twig', [
            'services'=> $services,
            'horaires'=>$horaires,
            'garages' => $garages,
        ]);
    }

    #[Route('/new', name: 'app_admin_services_new', methods: ['GET', 'POST'])]
    public function new(Request $request,EntityManagerInterface $manager,GarageRepository $garagesRepository,HorairesRepository $horairesRepository,ServicesRepository $repository): Response
    {
        
        $service = new Services();
        $form = $this->createForm(ServicesType::class,$service);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($service);
            $manager->flush();

            return $this->redirectToRoute('app_admin_services_show');
        }
        $services = $repository->findAll();
        $horaires = $horairesRepository->findAll();
        $garages = $garagesRepository->findAll();
        return $this->render('admin/services/new.html.twig', [
            'form' => $form,
            'services' => $services,
            'horaires'=>$horaires,
            'garages' => $garages,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_admin_services_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(?Services $services, Request $request,GarageRepository $garagesRepository,HorairesRepository $horairesRepository, EntityManagerInterface $manager): Response
    {
        $services ??= new Services();
        $form = $this->createForm(ServicesType::class, $services);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('pathImage')->getData();
        
            if ($imageFile) {
                $newFilename = md5(uniqid()).'.'.$imageFile->guessExtension();
        
                // Déplace le fichier dans le répertoire de uploads
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
        
                // Met à jour la propriété 'pathImage' de votre entité avec le nouveau nom de fichier
                $services->setPathImage($newFilename);
            }
        
                // Persistance de l'entité et sauvegarde
                $manager->persist($services);
                $manager->flush();
        
            return $this->redirectToRoute('app_admin_services_show');
        }
        $horaires = $horairesRepository->findAll();
        $garages = $garagesRepository->findAll();
        return $this->render('admin/services/edit.html.twig', [
            'form' => $form,
            'services' => $services, // Passer l'entité services au template
            'horaires'=>$horaires,
            'garages' => $garages,
        ]);
    }
}