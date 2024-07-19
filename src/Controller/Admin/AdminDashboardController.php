<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use App\Repository\GarageRepository;
use App\Repository\AnnoncesRepository;
use App\Repository\HorairesRepository;
use App\Repository\MessagesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'app_admin_dashboard')]
    public function dashboardAdmin(MessagesRepository $messagesRepository, AnnoncesRepository $annoncesRepository , GarageRepository $repository,HorairesRepository $horairesRepository,UserRepository $UserRepository): Response
    {   
        $users = $UserRepository->findAll();
        $garages = $repository->findAll();
        $horaires = $horairesRepository->findAll();
        $totalcars = $annoncesRepository->count();
        $totalmessages = $messagesRepository->countMessageNotArchived();
        
        return $this->render('admin/dashboard/dashboardAdmin.html.twig', [
            'garages'=>$garages,
            'horaires'=>$horaires,
            'users'=>$users,
            'totalcars' => $totalcars,
            'totalmessages' => $totalmessages,
            
        ]);
    }

    #[Route('/admin/dashboardUsers', name: 'app_admin_dashboardUsers')]
    public function dashboardUsers(GarageRepository $repository,HorairesRepository $horairesRepository,UserRepository $UserRepository): Response
    {   
        $users = $UserRepository->findAll();
        $garages = $repository->findAll();
        $horaires = $horairesRepository->findAll();
        return $this->render('admin/dashboard/dashboardUsers.html.twig', [
            'garages'=>$garages,
            'horaires'=>$horaires,
            'users'=>$users,
            
        ]);
    }
}
