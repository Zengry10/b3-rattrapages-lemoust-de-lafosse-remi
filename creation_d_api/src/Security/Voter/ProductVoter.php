<?php

namespace App\Security\Voter;

use App\Entity\BasketItem;
use App\Entity\Product;
use App\Entity\ProductRating;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ProductVoter extends Voter
{
    public const CAN_RATE = "CAN_RATE_PRODUCT";

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::CAN_RATE && $subject instanceof Product;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        /** @var Product $subject */
        /** @var User $user */
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        $hasRatedProduct = $this->entityManager
            ->getRepository(ProductRating::class)
            ->hasUserRatedProduct(
                $user->getId(),
                $subject->getId()
            )
        ;

        $hasPurchasedProduct = $this->entityManager
            ->getRepository(BasketItem::class)
            ->hasUserPurchasedProduct(
                $user->getId(),
                $subject->getId()
            )
        ;

        if ($hasRatedProduct || !$hasPurchasedProduct) {
            return false;
        }

        return true;
    }
}