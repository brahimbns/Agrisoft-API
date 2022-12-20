<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

//    private UserPasswordHasherInterface $UserPasswordHasherInterface;
//
//    public function __construct (UserPasswordHasherInterface $UserPasswordHasherInterface)
//    {
//        $this->UserPasswordHasherInterface = $UserPasswordHasherInterface;
//    }
    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user->setUsername('brahim');
        $user->setEmail('test12@brahim.com');
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            'secret123$'
        ));
        $user->setRetypedPassword('secret123$');
        $user->setFirstname('brahimbns');
        $user->setLastname('bns');
        $manager->persist($user);
        $manager->persist($user);

        $manager->flush();

    }
}
