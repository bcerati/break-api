<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->passwordEncoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->loadUsers();
        $this->manager->flush();
    }

    private function loadUsers():void{
        $users = [
            ['cool@gmail.com','azerty',[]],
            ['ru10@gmail.com','azerty',['ROLE_MANAGER']],
            ['denis@gmail.com','azerty',[]],
            
        ];
    
        foreach($users as $key => [$email,$password,$roles]){
            $user = (new User())
                ->setEmail($email)
                ->setRoles($roles);
            
            $user->setPassword($this->passwordEncoder->encodePassword($user,$password));

            $this->manager->persist($user);
        }
    }

    
}
