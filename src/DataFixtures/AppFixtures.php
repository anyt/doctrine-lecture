<?php

namespace App\DataFixtures;

use App\Entity\Chat;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setName('admin');
        $mainChat = (new Chat())->setName('admin_chat');
        $admin->setMainChat($mainChat);
        $manager->persist($mainChat);
        $manager->persist($admin);

        $chats = [];
        for ($i = 1; $i <= 100; $i++) {
            $chats[$i] = new Chat();
            $chats[$i]->setName('chat_'. $i);
            $chats[$i]->setAdmin($admin);
            $manager->persist($chats[$i]);
        }

        $users = [];
        for ($i = 1; $i <= 500; $i++) {
            $users[$i] = new User();
            $users[$i]->setName('user_'. $i);

            $users[$i]->setMainChat($this->getRandomChat($chats));
            $users[$i]->addChat($this->getRandomChat($chats));
            $users[$i]->addChat($this->getRandomChat($chats));
            $users[$i]->addChat($this->getRandomChat($chats));
            $users[$i]->addChat($this->getRandomChat($chats));

            $users[$i]->addAdministratedChat($this->getRandomChat($chats));
            $users[$i]->addAdministratedChat($this->getRandomChat($chats));
            $users[$i]->addAdministratedChat($this->getRandomChat($chats));
            $manager->persist($users[$i]);
        }

        $manager->flush();
    }

    private function getRandomChat(array $chats): Chat
    {
        return $chats[array_rand($chats)];
    }
}
