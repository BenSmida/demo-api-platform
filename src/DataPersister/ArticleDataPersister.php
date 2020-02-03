<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

final class ArticleDataPersister implements ContextAwareDataPersisterInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Article;
    }

    public function persist($data, array $context = [])
    {
        // call your persistence layer to save $data
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        return $data->getId();
    }

    public function remove($data, array $context = [])
    {
        // call your persistence layer to delete $data
        $data->setIsDeleted(true);
    }
}