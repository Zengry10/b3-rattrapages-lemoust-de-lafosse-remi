<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const TEST_USERNAME = "user";

    private const ADMIN_USERNAME = "admin";

    private const ADMIN_PASSWORD = "password";

    private const USERS_PASSWORD = "password";

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $admin = new User();

        $admin
            ->setUsername(self::ADMIN_USERNAME)
            ->setPassword($this->userPasswordHasher->hashPassword($admin, self::ADMIN_PASSWORD))
            ->setRoles(["ROLE_ADMIN"])
        ;

        $testUser = new User();

        $testUser
            ->setUsername(self::TEST_USERNAME)
            ->setPassword($this->userPasswordHasher->hashPassword($testUser, self::USERS_PASSWORD))
        ;

        $manager->persist($admin);
        $manager->persist($testUser);

        $manager->flush();

        for ($i = 0; $i < 45; $i++) {
            $product = new Product();

            $product
                ->setName($faker->words(2, true))
                ->setDescription($faker->sentences(3, true))
                ->setPrice($faker->numberBetween(1000, 90000))
                ->setNote($faker->sentences(5, true))
                ->setUnitsRemaining($faker->numberBetween(0, 100))
                ->setImagePath("66a9eb3b4f7e7486532019.png");
            ;

            $manager->persist($product);
        }

        $manager->flush();
    }
}
