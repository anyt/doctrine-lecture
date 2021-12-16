<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function index(EntityManagerInterface $em, UserRepository $userRepository): Response
    {
        # fetch all with lazy-loading that produce many extra database queries that are bad for performance
        $users = $em->getRepository(User::class)->findAll();

        # or write an inline query

//        $users = $em->createQueryBuilder()
//            ->from('App\Entity\User', 'u')
//            ->select('u,m,c')
//            ->join('u.mainChat', 'm')
//            ->join('u.chats', 'c')
//            ->getQuery()
//            ->getResult();

        # or reuse the query from repository
        $users = $userRepository->getUsersWithChats();

        $response = array_map(function (User $user) {
            return [
                'name' => $user->getName(),
                'mainChat' => $user->getMainChat()->getName(),
                'chats' => array_map(fn (Chat $chat) => $chat->getName(), $user->getChats()->toArray()),
            ];
        }, $users);


        return $this->json($response);
    }
}
