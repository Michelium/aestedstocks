<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Page", inversedBy="children", cascade={"persist", "remove"})
     */
    private $parent_page;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Page", mappedBy="parent_page", cascade={"persist", "remove"})
     */
    private $children;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modified_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PageContentBlock", mappedBy="page", orphanRemoval=true)
     */
    private $pageContentBlocks;

    public function __construct()
    {
        $this->pageContentBlocks = new ArrayCollection();
    }

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getParentPage(): ?self
    {
        return $this->parent_page;
    }

    public function setParentPage(?self $parent_page): self
    {
        $this->parent_page = $parent_page;

        return $this;
    }

    public function getChildren(): ?self
    {
        return $this->children;
    }

    public function setChildren(?self $children): self
    {
        $this->children = $children;

        // set (or unset) the owning side of the relation if necessary
        $newParent_page = null === $children ? null : $this;
        if ($children->getParentPage() !== $newParent_page) {
            $children->setParentPage($newParent_page);
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modified_at;
    }

    public function setModifiedAt(\DateTimeInterface $modified_at): self
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    /**
     * @return Collection|PageContentBlock[]
     */
    public function getPageContentBlocks(): Collection
    {
        return $this->pageContentBlocks;
    }

    public function addPageContentBlock(PageContentBlock $pageContentBlock): self
    {
        if (!$this->pageContentBlocks->contains($pageContentBlock)) {
            $this->pageContentBlocks[] = $pageContentBlock;
            $pageContentBlock->setPage($this);
        }

        return $this;
    }

    public function removePageContentBlock(PageContentBlock $pageContentBlock): self
    {
        if ($this->pageContentBlocks->contains($pageContentBlock)) {
            $this->pageContentBlocks->removeElement($pageContentBlock);
            // set the owning side to null (unless already changed)
            if ($pageContentBlock->getPage() === $this) {
                $pageContentBlock->setPage(null);
            }
        }

        return $this;
    }
}
