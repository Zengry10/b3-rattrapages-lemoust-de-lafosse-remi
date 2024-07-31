<?php

namespace App\Controller;

use App\Entity\Basket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[AsController]
class UserCheckoutBasketController extends AbstractController
{
    public function __invoke(
        EntityManagerInterface $entityManager
    ): Basket {
        $user = $this->getUser();

        $validatedBasket = $entityManager->getRepository(Basket::class)->getValidatedBasket($user->getId());

        if ($validatedBasket === null) {
            throw new NotFoundHttpException("No validated basket available");
        }

        return $validatedBasket;
    }
}
