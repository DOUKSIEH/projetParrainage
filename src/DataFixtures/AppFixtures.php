<?php

namespace App\DataFixtures;


use Faker\Factory;
//use App\Entity\Role;
use App\Entity\User;
use App\Entity\Filleul;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
//use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture 
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
       
        // Nous gérons les utilisateurs
        $users = [];
        //
        $genres = ['male', 'female'];
        

        for ($i = 1; $i <= 10; $i++) {

            $user = new User();

            $genre = $faker->randomElement($genres);

            $image = 'https://randomuser.me/api/portraits/';

            $imageId = $faker->numberBetween(1, 99) . '.jpg';

            $image .= ($genre == 'male' ? 'men/' : 'women/') . $imageId;

            $hash = $this->encoder->encodePassword($user, 'isman');

            

            $user->setPrenom($faker->firstname($genre))
                    ->setNom($faker->lastname)
                    ->setEmail($faker->email)
                    ->setAdresse($faker->address())
                    ->setVille( $faker->city())
                    ->setPassword($hash)
                    ->setTelephone($faker->randomNumber($nbDigits = NULL, $strict = false))
                    ->setImage($image);
            $manager->persist($user);
            $users[] = $user;
        }

        // Nous gérons les evenements

            for ($i = 1; $i <= 30; $i++) 
            {

                $filleul = new Filleul();

                $user = $users[mt_rand(0, count($users) - 1)];

                $filleul->setPrenom($faker->firstname($genre))
                        ->setNom($faker->lastname)
                        ->setAge(mt_rand(3,18))
                        ->setGenre($faker->randomElement($genres))
                        ->setAdresse($faker->address())
                        ->setVille($faker->city())
                        ->setImage($image)
                        ->setParrain($user);

     
                $manager->persist($filleul);

            }
        
        $manager->flush();
    }
   
}
