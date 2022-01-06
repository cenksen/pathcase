<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Cocur\Slugify\Slugify;

class UserFixtures extends Fixture
{

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
            $passwordHash = hash('sha256',$stringHash);

            $user = new User($email);
            $user->setFirstName($firstname);
            $user->setLastName($lastname);
            $user->setUsername($email);
            $user->setPassword($passwordHash);
            $manager->persist($user);
        }
        $manager->flush();


    }
    /**
     * @param UserInterface $user
     * @param JWTTokenManagerInterface $JWTManager
     * @return JsonResponse
     */
    public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTManager)
    {
        return new JsonResponse(['token' => $JWTManager->create($user)]);
    }
}
