<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Role;
//use App\Entity\Role;
use App\Entity\User;
use App\Entity\Donneur;
use App\Entity\Filleul;
use App\Service\ValidationService;
//use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture 
{
    private $encoder;
    private $token;

    public function __construct(UserPasswordEncoderInterface $encoder, ValidationService $token)
    {
        $this->encoder = $encoder;
        $this->token = $token;
    }
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        // ajouter un nouveau
        $adminRole = new Role();
        $adminRole->setTitre('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new User();     
        $adminUser->setPrenom('Douksieh')
                  ->setNom('Isman')
                  ->setEmail('ismanhassan18@gmail.com')
                  ->setPassword($this->encoder->encodePassword($adminUser, 'password'))
                  ->setImage('https://randomuser.me/api/portraits/men/63.jpg')
                  ->setAdresse($faker->address())
                  ->setVille( $faker->city())
                  ->setToken($this->token->str_random())
                  ->setTelephone($faker->randomNumber($nbDigits = NULL, $strict = false))
                  ->addUserRole($adminRole)
                  ;
        $manager->persist($adminUser);
       
        // Nous gérons les utilisateurs
        $users = [];
        //
        $genres = ['male', 'female'];
        

        for ($i = 1; $i <= 50; $i++) {

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
                    ->setToken($this->token->str_random())
                    ->setImage($image);
            $manager->persist($user);
            $users[] = $user;
        }

        // Nous gérons les evenements

            for ($i = 1; $i <= 50; $i++) 
            {

                $filleul = new Filleul();

                $user = $users[mt_rand(0, count($users) - 1)];

                $genre = $faker->randomElement($genres);

               

                $image = 'https://randomuser.me/api/portraits/';
     
                $imageId = $faker->numberBetween(1, 99) . '.jpg';
     
                $image .= ($genre == 'male' ? 'men/' : 'women/') . $imageId;

                $filleul->setPrenom($faker->firstname($genre))
                        ->setNom($faker->lastname)
                        ->setAge(mt_rand(3,18))
                        ->setGenre($faker->randomElement($genres))
                        ->setAdresse($faker->address())
                        ->setPays($faker->country())
                        ->setImage($image)
                        ->setParrain($user);

     
                $manager->persist($filleul);

            }

            for ($i = 1; $i <= 50; $i++) 
            {

                $donneur = new Donneur();

                //$user = $users[mt_rand(0, count($users) - 1)];

                $donneur->setPrenom($faker->firstname($genre))
                        ->setNom($faker->lastname)
                        ->setAdresse($faker->address())
                        ->setVille($faker->city())
                        ->setTelephone($faker->randomNumber($nbDigits = NULL, $strict = false))
                        ->setEmail($faker->email);

     
                $manager->persist($donneur);

            }
            
        
        $manager->flush();
    }
   
}
