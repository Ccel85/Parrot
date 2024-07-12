<?php

namespace App\Controller\Admin;

use App\Entity\Garage;
use App\Form\GarageType;
use App\Repository\GarageRepository;
use App\Repository\HorairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/garage')]
class GarageController extends AbstractController
{
    #[Route('', name: 'app_admin_garage')]
    public function index(GarageRepository $repository,HorairesRepository $horairesRepository): Response
    {
        $garages = $repository->findAll();
        $horaires = $horairesRepository->findAll();
        return $this->render('admin/garage/index.html.twig',[
            'garages'=>$garages,
            'horaires'=>$horaires,
        ]);
    }

    #[Route('/new', name: 'app_admin_garage_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_admin_garage_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Garage $garage, Request $request,HorairesRepository $horairesRepository,EntityManagerInterface $manager,GarageRepository $repository): Response
    {
        
        $garage ??= new Garage();
        $form = $this->createForm(GarageType::class,$garage);
        

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($garage);
            $manager->flush();

            return $this->redirectToRoute('app_admin_garage');
        }
        $garages = $repository->findAll();
        $horaires = $horairesRepository->findAll();
        return $this->render('admin/garage/new.html.twig', [
            'form' => $form,
            'garages' => $garages,
            'horaires'=>$horaires,
        ]);
    }
}
