<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Cocur\Slugify\Slugify;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('tr_TR');
        for ($i = 0; $i < 3; $i++) {
            $slugify = new Slugify();
            $firstname = $faker->firstName();
            $lastname = $faker->lastName();
            $email = $firstname.'.'.$lastname;
            $slugify->activateRuleSet('turkish');
            $email = $slugify->slugify($email, '.');
            $email = $email.'@abccompany.com';
            $stringHash = $slugify->slugify($firstname).'123';

            $user = new User($email);
            $user->setFirstName($firstname);
            $user->setLastName($lastname);
            $user->setUsername($email);
            $user->setPassword($this->encoder->encodePassword($user, $stringHash));
            $manager->persist($user);
        }
        $manager->flush();


    }
}
