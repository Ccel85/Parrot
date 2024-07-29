<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use App\Repository\GarageRepository;
use App\Repository\AnnoncesRepository;
use App\Repository\CommentsRepository;
use App\Repository\HorairesRepository;
use App\Repository\MessagesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashboardController extends AbstractController
{
    #[Route('/admin/dashboardAdmin', name: 'app_admin_dashboard')]
    public function dashboardAdmin(MessagesRepository $messagesRepository,CommentsRepository $commentsRepository, AnnoncesRepository $annoncesRepository , GarageRepository $repository,HorairesRepository $horairesRepository,UserRepository $UserRepository): Response
    {
        $users = $UserRepository->findAll();
        $garages = $repository->findAll();
        $horaires = $horairesRepository->findAll();
        $totalcars = $annoncesRepository->count();
        $totalCommments = $commentsRepository->countCommentsNotArchived();
        $totalMessages = $messagesRepository->countMessageNotArchived();
        
        return $this->render('admin/dashboard/dashboardAdmin.html.twig', [
            'garages'=>$garages,
            'horaires'=>$horaires,
            'users'=>$users,
            'totalcars' => $totalcars,
            'totalmessages' => $totalMessages,
            'totalCommments' => $totalCommments,
            
        ]);
    }

    #[Route('/admin/dashboardUsers', name: 'app_admin_dashboardUsers')]
    public function dashboardUsers(MessagesRepository $messagesRepository,CommentsRepository $commentsRepository, AnnoncesRepository $annoncesRepository , GarageRepository $repository,HorairesRepository $horairesRepository,UserRepository $UserRepository): Response
    {
        $users = $UserRepository->findAll();
        $garages = $repository->findAll();
        $horaires = $horairesRepository->findAll();
        $totalcars = $annoncesRepository->count();
        $totalCommments = $commentsRepository->countCommentsNotArchived();
        $totalMessages = $messagesRepository->countMessageNotArchived();
        
        return $this->render('admin/dashboard/dashboardUsers.html.twig', [
            'garages'=>$garages,
            'horaires'=>$horaires,
            'users'=>$users,
            'totalcars' => $totalcars,
            'totalmessages' => $totalMessages,
            'totalCommments' => $totalCommments,
            
        ]);
    }
}
