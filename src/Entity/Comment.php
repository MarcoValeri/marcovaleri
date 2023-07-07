<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private ?string $articleUrl = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    private string $email;

    #[ORM\Column(length: 10)]
    private ?string $date;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content;

    #[ORM\OneToMany(targetEntity: Article::class, mappedBy: 'comment')]
    private $comment;

    #[ORM\Column(type: 'boolean')]
    private $approved = false;

    public function __construct()
    {
        $this->comment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticleUrl(): ?string
    {
        return $this->articleUrl;
    }

    public function setArticleUrl(string $articleUrl): self
    {
        $this->articleUrl = $articleUrl;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

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

    /**
     * @return Collection|Article[]
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    public function addComment(Article $comment): self
    {
        if (!$this->comment->contains($comment)) {
            $this->comment[] = $comment;
            $comment->setComments($this);
        }

        return $this;
    }

    public function removeComment(Article $comment): self
    {
        if ($this->comment->removeElement($comment)) {
            if ($comment->getComments() === $this) {
                $comment->setComments(null);
            }
        }

        return $this;
    }

    public function getApproved(): bool
    {
        return $this->approved;
    }

    public function setApproved(bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }

    public function __toString() {
        return $this->name;
    }
}