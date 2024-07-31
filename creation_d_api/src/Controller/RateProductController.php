<?php

namespace App\Controller;

use App\Entity\Product;
use App\Request\RateProductRequest;
use App\Security\Voter\ProductVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[AsController]
class RateProductController extends AbstractController
{
    public function __invoke(
        Security $security,
        RateProductRequest $request,
        EntityManagerInterface $entityManager
    ): RateProductRequest {
        $product = $entityManager->getRepository(Product::class)->find($request->productId);

        if ($product === null) {
            throw new NotFoundHttpException(sprintf("Product with ID %s not found", $request->productId));
        }

        if (!$security->isGranted(ProductVoter::CAN_RATE, $product)) {
            throw new AccessDeniedHttpException("You do not have the required permissions to rate this product");
        }

        return $request;
    }
}
