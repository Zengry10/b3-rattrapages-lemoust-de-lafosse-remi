<?php

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class ProductImageController extends AbstractController
{
    public function __invoke(Request $request, ValidatorInterface $validator): Product
    {
        $product = new Product();

        $product->setName($request->request->get("name"));
        $product->setDescription($request->request->get("description"));
        $product->setPrice($request->request->get("price"));
        $product->setNote($request->request->get("note"));
        $product->setUnitsRemaining($request->request->get("unitsRemaining"));

        $product->imageFile = $request->files->get("imageFile");

        $validator->validate($product);

        return $product;
    }
}
