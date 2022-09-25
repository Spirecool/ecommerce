<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UsersFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        private SluggerInterface $slugger
        ){}

    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setEmail('admin@ecommerce.fr');
        $admin->setLastname('Ollivier');
        $admin->setFirstname('Jérôme');
        $admin->setAddress('12 rue du Bari');
        $admin->setZipcode('45740');
        $admin->setCity('Lailly-en-Val');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'password')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        //ici on va créer des faux utilisateurs
        $faker = Faker\Factory::create('fr_FR');

        for($usr = 1; $usr <= 10; $usr++) {
            $user = new Users();
            $user->setEmail($faker->email);
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setAddress($faker->streetAddress);
            $user->setZipcode(str_replace(' ', '',$faker->postcode)); // on enlève les espaces dans les zipcodes de Faker
            $user->setCity($faker->city);
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, 'password')
            );
            $manager->persist($user);
        }

        $manager->flush();
    }
}
