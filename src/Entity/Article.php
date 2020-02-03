<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use App\Controller\Article\ArticlePublishController;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ApiResource(
 *     attributes={
 *          "order"={"id": "DESC"},
 *          "pagination_enabled"=false
 *     },
 *     collectionOperations={
 *          "get"={
 *               "security"="is_granted('ROLE_USER')",
 *               "security_message"="You don't have access to this!",
 *               "normalization_context"={"groups"={"list:output"}}
 *          },
 *          "post"={
 *               "security"="is_granted('ROLE_ADMIN')",
 *               "security_message"="Only admin can do this!"
 *          }
 *     },
 *     itemOperations={
 *          "get"={
 *               "security"="is_granted('ROLE_USER')",
 *               "normalization_context"={"groups"={"output"}}
 *          },
 *          "put"={
 *               "security"="is_granted('ROLE_ADMIN') and object.getCreatedBy() == user"
 *          },
 *          "delete"={
 *               "security"="object.getCreatedBy() == user"
 *          },
 *          "post_publication"={
 *              "method"="POST",
 *              "path"="/articles/{id}/publish",
 *              "controller"=ArticlePublishController::class,
 *           }
 *     },
 *     normalizationContext={"groups"={"output"}},
 *     denormalizationContext={"groups"={"input"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={"title": "partial"})
 * @ApiFilter(DateFilter::class, properties={"createdAt"})
 * @ApiFilter(OrderFilter::class, properties={"id", "createdAt"}, arguments={"orderParameterName"="order"})
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"list:output", "output"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list:output", "output", "input"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"list:output", "output", "input"})
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished = false;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"list:output", "output"})
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"list:output", "output"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"list:output", "output", "input"})
     */
    private $category;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDeleted = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="articles")
     */
    private $createdBy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"list:output", "output", "input"})
     */
    private $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }


    public function setPublishedAt(\DateTimeInterface $createdAt): self
    {
        $this->publishedAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt(): self
    {
        $this->createdAt = new \DateTime();

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }
}
