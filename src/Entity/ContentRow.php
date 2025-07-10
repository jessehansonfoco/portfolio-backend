<?php

namespace App\Entity;

use App\Repository\ContentRowRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity(repositoryClass: ContentRowRepository::class)]
#[Index(name:"IDX_CONTENT_ROW_TITLE", columns: ["title"])]
#[Index(name:"IDX_CONTENT_ROW_SORT_ORDER", columns: ["sort_order"])]
class ContentRow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ManyToOne(targetEntity: "Content", cascade: ["all"], fetch: "EAGER")]
    private ?Content $content;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    private ?int $sort_order = null;

    #[OneToMany(targetEntity: "ContentRowPart", mappedBy: "content_row", cascade: ["persist", "remove"], orphanRemoval: true)]
    protected Collection $content_row_parts;

    public function __construct()
    {
        $this->content_row_parts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setContent(?Content $content): static
    {
        $this->content = $content;
        return $this;
    }

    public function getContent(): ?Content
    {
        return $this->content;
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

    public function getSortOrder(): ?int
    {
        return $this->sort_order;
    }

    public function setSortOrder(int $sort_order): static
    {
        $this->sort_order = $sort_order;
        return $this;
    }

    /**
     * @return Collection<int, ContentRowPart>
     */
    public function getContentRowParts(): Collection
    {
        return $this->content_row_parts;
    }

    /**
     * @param ContentRowPart $contentRow
     * @return $this
     */
    public function addContentRowPart(ContentRowPart $contentRow): static
    {
        if (!$this->content_row_parts->contains($contentRow)) {
            $this->content_row_parts->add($contentRow);
            $contentRow->setContentRow($this);
        }
        return $this;
    }

    /**
     * @param ContentRowPart $contentRow
     * @return $this
     */
    public function removeContentRowPart(ContentRowPart $contentRow): static
    {
        if ($this->content_row_parts->removeElement($contentRow)) {
            if ($contentRow->getContentRow() === $this) {
                $contentRow->setContentRow(null);
            }
        }
        return $this;
    }
}
