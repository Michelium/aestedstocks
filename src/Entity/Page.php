<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 * @UniqueEntity("title")
 * @UniqueEntity("slug")
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
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Page", inversedBy="children", cascade={"persist", "remove"})
     */
    private $parent_page;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Page", mappedBy="parent_page", cascade={"persist", "remove"})
     */
    private $children;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modified_at = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PageContentBlock", mappedBy="page", orphanRemoval=true)
     */
    private $pageContentBlocks;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="pages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $created_by;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $modified_by;

    public function __construct()
    {
        $this->created_at = new \DateTime('now');
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

    /**
     * @return mixed
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void {
        $this->content = $content;
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

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $created_by): self
    {
        $this->created_by = $created_by;

        return $this;
    }

    public function getModifiedBy(): ?User
    {
        return $this->modified_by;
    }

    public function setModifiedBy(?User $modified_by): self
    {
        $this->modified_by = $modified_by;

        return $this;
    }
}
