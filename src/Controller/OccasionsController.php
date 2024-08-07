<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Annonces;
use App\Form\AnnoncesType;
use App\Repository\GarageRepository;
use App\Repository\AnnoncesRepository;
use App\Repository\HorairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class OccasionsController extends AbstractController
{
    #[Route('/occasions', name: 'app_occasions_index')]
    public function index(AnnoncesRepository $annoncesrepository,HorairesRepository $horairesRepository,GarageRepository $garagerepository): Response
    {
        $minMaxValues = $annoncesrepository->minMaxRange();
        $annonces = $annoncesrepository->findAll();
        $garages = $garagerepository->findAll();
        $horaires = $horairesRepository->findAll();
        return $this->render('occasions/index.html.twig', [
            'annonces' => $annonces,
            'garages' => $garages,
            'horaires'=>$horaires,
            'minMaxValues' => $minMaxValues,

        ]);
    }

    #[Route('/occasions/{id}/details', name: 'app_occasions_details', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function details($id,AnnoncesRepository $annoncesRepository,HorairesRepository $horairesRepository,GarageRepository $garagerepository): Response
    {
        $annonces =  $annoncesRepository->findOneBy(['id' => $id]);
        if (!$annonces) {
            throw $this->createNotFoundException('L\'annonce n\'existe pas.');
        }
        $equipementExterieur = explode(',', $annonces->getEquipementExterieur());
        $equipementInterieur = explode(',', $annonces->getEquipementInterieur());
        $autresEquipements = $annonces->getAutresEquipements() ? explode(',', $annonces->getAutresEquipements()) : [];
        $garages = $garagerepository->findAll();
        $horaires = $horairesRepository->findAll();
    
        return $this->render('/occasions/details.html.twig', [
            'annonces' => $annonces,
            'garages' => $garages,
            'horaires'=>$horaires,
            'equipementExterieur' => $equipementExterieur,
            'equipementInterieur' => $equipementInterieur,
            'autresEquipements' => $autresEquipements,
            
        ]);
    }

    #[Route('admin/occasions/new', name: 'app_occasions_new',methods: ['GET', 'POST'])]
    public function new(Request $request,EntityManagerInterface $manager,HorairesRepository $horairesRepository,GarageRepository $garagerepository): Response
    {
        $annonces = new Annonces();
        $annonces->setCreatedAtValue(); // Initialiser la date de création
        $form = $this->createForm(AnnoncesType::class,$annonces);

        $form-> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($annonces);
            $manager->flush();

            return $this->redirectToRoute('app_occasions_show');
        }
        $garages = $garagerepository->findAll();
        $horaires = $horairesRepository->findAll();
        return $this->render('admin/occasions/new.html.twig', [
            'garages' => $garages,
            'horaires'=>$horaires,
            'form' => $form->createView(),

        ]);
    }

    #[Route('admin/occasions/show', name: 'app_occasions_show')]
    public function show(AnnoncesRepository $annoncesrepository,HorairesRepository $horairesRepository,GarageRepository $garagerepository): Response
    {
        
        $annonces = $annoncesrepository->findAll();
        $garages = $garagerepository->findAll();
        $horaires = $horairesRepository->findAll();
        return $this->render('admin/occasions/show.html.twig', [
            'annonces' => $annonces,
            'garages' => $garages,
            'horaires'=>$horaires,
        

        ]);
    }

    #[Route('occasions/{id}/edit', name: 'app_occasions_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(?Annonces $annonces, Request $request,GarageRepository $garagesRepository,HorairesRepository $horairesRepository, EntityManagerInterface $manager,SluggerInterface $slugger): Response
    {
            $annonces ??= new Annonces();
            $form = $this->createForm(AnnoncesType::class, $annonces);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $action = $request->request->get('action');
                if ($action === 'save') {
                    $image = $form->get('images')->getData();

                    foreach ($image as $imageFile) {
                        if ($imageFile) {
                            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                            $safeFilename = $slugger->slug($originalFilename);
                            $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                            try {
                                $imageFile->move(
                                    $this->getParameter('images_directory'),
                                    $newFilename
                                );
                            } catch (FileException $e) {
                                // Gérer l'exception selon vos besoins
                            }

                            $image = new Images();
                            $image->setFilename($newFilename);
                            $image->setPathImages($annonces); // Associer l'image à l'annonce
                            $annonces->addImage($image); // Ajouter l'image à l'annonce
                        }
                    }
                            $manager->persist($annonces);
                            $manager->flush();
                
                return $this->redirectToRoute('app_occasions_show');
            }
            if ($action === 'delete') {
                return $this->redirectToRoute('annonce_remove', ['id' => $annonces->getId()]);
            } else {
                return $this->redirectToRoute('app_occasions_show');
            }
            }
            $horaires = $horairesRepository->findAll();
            $garages = $garagesRepository->findAll();
            return $this->render('admin/occasions/edit.html.twig', [
                'form' => $form->createView(),
                'annonces' => $annonces, // Passer l'entité annonces au template
                'horaires'=>$horaires,
                'garages' => $garages,
            ]);
        
    }
    
    #[Route('/annonce/{id}/remove', name: 'annonce_remove')]
        public function remove(Annonces $annonces, EntityManagerInterface $entityManager): Response
        {
            $entityManager->remove($annonces);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_occasions_show');
        }
}


