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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OccasionsController extends AbstractController
{
    #[Route('/occasions', name: 'app_occasions_index',methods: ['GET'])]
    public function index(AnnoncesRepository $annoncesrepository,HorairesRepository $horairesRepository,GarageRepository $garagerepository): Response
    {
        $annonces = $annoncesrepository->findAll();
        $garages = $garagerepository->findAll();
        $horaires = $horairesRepository->findAll();
        return $this->render('occasions/index.html.twig', [
            'annonces' => $annonces,
            'garages' => $garages,
            'horaires'=>$horaires,

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
            // On récupère les images transmises
        $images = $form->get('images')->getData();
    
        // On boucle sur les images
        foreach($images as $image){
            // On génère un nouveau nom de fichier
            $fichier = md5(uniqid()).'.'.$image->guessExtension();
        
            // On copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('images_directory'),
                $fichier
            );
            // On crée l'image dans la base de données
            $img = new Images();
            $img->setImagesfiles($fichier);
            $annonces->addImage($img);
        }
            $manager->persist($annonces);
            $manager->flush();

            return $this->redirectToRoute('app_occasions_show');
        }
        $garages = $garagerepository->findAll();
        $horaires = $horairesRepository->findAll();
        return $this->render('admin/occasions/new.html.twig', [
            'garages' => $garages,
            'horaires'=>$horaires,
            'form' => $form,
            'annonces' => $annonces,

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

    #[Route('admin/occasions/{id}/edit', name: 'app_occasions_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(?Annonces $annonces, Request $request,GarageRepository $garagesRepository,HorairesRepository $horairesRepository, EntityManagerInterface $manager): Response
    {
        $annonces ??= new Annonces();
        $form = $this->createForm(AnnoncesType::class, $annonces);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion de la suppression des images sélectionnées
            $imagesToDelete = $request->get('delete_images', []);
            if (!empty($imagesToDelete)){
                foreach ($imagesToDelete as $imageId) {
                    $image = $manager->getRepository(Images::class)->find($imageId);
                    if ($image) {
                        $annonces->removeImage($image);
                        $manager->remove($image);
                    }
                }
            }
                // On récupère les images transmises
            $images = $form->get('images')->getData();
            // On boucle sur les images
            foreach($images as $image){
            // On génère un nouveau nom de fichier
            $fichier = md5(uniqid()).'.'.$image->guessExtension();
            // On copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('images_directory'),
                $fichier
            );
            // On crée l'image dans la base de données
            $img = new Images();
            $img->setImagesfiles($fichier);
            $annonces->addImage($img);
        }
            $manager->persist($annonces);
            $manager->flush();

            return $this->redirectToRoute('app_occasions_show');
        }
        $horaires = $horairesRepository->findAll();
        $garages = $garagesRepository->findAll();
        return $this->render('admin/occasions/edit.html.twig', [
            'form' => $form,
            'annonces' => $annonces, // Passer l'entité annonces au template
            'horaires'=>$horaires,
            'garages' => $garages,
        ]);
    }

    #[Route('/occasions/{id}/delete', name: 'app_occasions_delete')]
    //#[IsGranted('ROLE_ADMIN')] // Optional: restrict access to admins
    public function delete(Request $request, Annonces $annonces, EntityManagerInterface $manager): Response
    {
        // Check CSRF token validity
        //if ($this->isCsrfTokenValid('delete'.$annonces->getId(), $request->request->get('_token'))) {
            
            $manager->remove($annonces);
            $manager->flush();

        return $this->redirectToRoute('app_occasions_show'); // Redirect to the listing page
    }
}
