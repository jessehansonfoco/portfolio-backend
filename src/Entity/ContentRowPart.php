<?php

namespace App\Entity;

use App\Repository\ContentRowPartRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity(repositoryClass: ContentRowPartRepository::class)]
class ContentRowPart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ManyToOne(targetEntity: "ContentRow", cascade: ["all"], fetch: "EAGER")]
    private ?ContentRow $content_row; // the serializer changes snake_case to camelCase

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type_code = null;

    #[ORM\Column(type: 'text', length: 65535, nullable: true)]
    private ?string $content;

    #[ORM\Column(nullable: true)]
    private ?int $sort_order = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_link_url = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setContentRow(?ContentRow $contentRow): static
    {
        $this->content_row = $contentRow;
        return $this;
    }

    public function getContentRow(): ?ContentRow
    {
        return $this->content_row;
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

    public function getTypeCode(): ?string
    {
        return $this->type_code;
    }

    public function setTypeCode(string $type_code): static
    {
        $this->type_code = $type_code;

        return $this;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
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

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(?string $image_url): static
    {
        $this->image_url = $image_url;
        return $this;
    }

    public function getImageLinkUrl(): ?string
    {
        return $this->image_link_url;
    }

    public function setImageLinkUrl(?string $image_link_url): static
    {
        $this->image_link_url = $image_link_url;
        return $this;
    }
}
