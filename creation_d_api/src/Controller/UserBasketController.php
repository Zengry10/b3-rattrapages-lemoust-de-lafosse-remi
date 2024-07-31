<?php

namespace App\Controller;

use App\Entity\Basket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[AsController]
class UserBasketController extends AbstractController
{
    public function __invoke(
        EntityManagerInterface $entityManager
    ): Basket {
        $user = $this->getUser();

        $activeBasket = $entityManager->getRepository(Basket::class)->getUserActiveBasket($user->getId());

        if ($activeBasket === null) {
            throw new NotFoundHttpException("No active basket available");
        }

        return $activeBasket;
    }
}
