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
        $user->setRoles(["ROLE_USER"]);
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

        $userAdmin = new User();

        $userAdmin->setUsername('brahimAdmin');
        $userAdmin->setEmail('brahimAdmin@brahim.com');
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $userAdmin->setPassword($this->passwordHasher->hashPassword(
            $userAdmin,
            'secret123$'
        ));
        $userAdmin->setRetypedPassword('secret123$');
        $userAdmin->setFirstname('brahimAdmin');
        $userAdmin->setLastname('bns');
        $manager->persist($userAdmin);
        $manager->persist($userAdmin);

        $manager->flush();
    }
}
