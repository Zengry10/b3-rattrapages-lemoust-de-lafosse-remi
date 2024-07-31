<?php

namespace App\Serializer\Normalizer;

use ApiPlatform\Doctrine\Orm\Paginator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PaginationNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface $normalizer
    ) {
    }
    /**
     * @inheritDoc
     */
    public function normalize($object, ?string $format = null, array $context = []): array
    {
        $items = [];

        foreach ($object as $item) {
            $items[] = $this->normalizer->normalize($item, $format, $context);
        }

        return [
            'collection' => $items,
            'totalItems' => $object->getTotalItems(),
            'itemsPerPage' => $object->getItemsPerPage(),
            'currentPage' => $object->getCurrentPage(),
            'totalPages' => ceil($object->getTotalItems() / $object->getItemsPerPage()),
        ];
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof Paginator; // && $format === 'json';
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Paginator::class => true];
    }
}
