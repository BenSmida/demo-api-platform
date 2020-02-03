<?php

namespace App\Controller\Article;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

class ArticlePublishController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(Article $data): Article
    {
        $data->setIsPublished(true);
        $data->setPublishedAt(new \DateTime());



        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}