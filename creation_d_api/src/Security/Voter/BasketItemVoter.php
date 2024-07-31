<?php

namespace App\Security\Voter;

use App\Entity\BasketItem;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class BasketItemVoter extends Voter
{
    public const DELETE = 'BASKET_ITEM_DELETE';

    public function __construct(
        private Security $security,
    ) {}

    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::DELETE && $subject instanceof BasketItem;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        /** @var BasketItem $subject */
        /** @var User $user */
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        return $this->security->isGranted("ROLE_ADMIN") ||
            $subject->getBasket()->getUser()->getId() === $user->getId()
        ;
    }
}