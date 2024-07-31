<?php

namespace App\Controller;

use App\Entity\Basket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[AsController]
class UserCancelBasketController extends AbstractController
{
    public function __invoke(
        EntityManagerInterface $entityManager
    ): Basket {
        $user = $this->getUser();

        $cancellableBasket = $entityManager->getRepository(Basket::class)->getCancellableBasket($user->getId());

        if ($cancellableBasket === null) {
            throw new NotFoundHttpException("No cancellable basket available");
        }

        return $cancellableBasket;
    }
}
