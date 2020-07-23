<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Users;
use App\Entity\UserProfils;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');


        for ($i=0; $i < 3; $i++) {    
            $profil = new UserProfils();
            $profil->setLibelle($faker->unique()->randomElement(['Admin', 'Formateur', 'CM'])); 
            $manager->persist($profil);        
            
            $user = new Users();
            $harsh = $this->encoder->encodePassword($user, 'password');

            $user->setUsername($faker->unique()->userName);
            $user->setPassword($harsh);
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setEmail($faker->email);
            $user->setProfil($profil);

            $manager->persist($user);

        }
        $manager->flush();
    }
}
