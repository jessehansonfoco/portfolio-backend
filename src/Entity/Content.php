<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Index;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\ContentRepository;

#[ORM\Entity(repositoryClass: ContentRepository::class)]
#[Index(name:"IDX_CONTENT_TITLE", columns: ["title"])]
#[Index(name:"IDX_CONTENT_SLUG", columns: ["slug"])]
#[Index(name:"IDX_CONTENT_SORT_ORDER", columns: ["sort_order"])]
class Content
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $short_description = null;

    #[ORM\Column(nullable: true)]
    private ?int $sort_order = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[OneToMany(targetEntity: "ContentRow", mappedBy: "content", cascade: ["persist", "remove"], orphanRemoval: true)]
    protected Collection $content_rows;

    public function __construct()
    {
        $this->content_rows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(string $imageUrl): static
    {
        $this->image_url = $imageUrl;
        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;
        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(string $short_description): static
    {
        $this->short_description = $short_description;

        return $this;
    }

    public function getSortOrder(): ?int
    {
        return $this->sort_order;
    }

    public function setSortOrder(int $sort_order): static
    {
        $this->sort_order = $sort_order;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, ContentRow>
     */
    public function getContentRows(): Collection
    {
        return $this->content_rows;
    }

    /**
     * @param ContentRow $contentRow
     * @return $this
     */
    public function addContentRow(ContentRow $contentRow): static
    {
        if (!$this->content_rows->contains($contentRow)) {
            $this->content_rows->add($contentRow);
            $contentRow->setContent($this);
        }
        return $this;
    }

    /**
     * @param ContentRow $contentRow
     * @return $this
     */
    public function removeContentRow(ContentRow $contentRow): static
    {
        if ($this->content_rows->removeElement($contentRow)) {
            if ($contentRow->getContent() === $this) {
                $contentRow->setContent(null);
            }
        }
        return $this;
    }
}
