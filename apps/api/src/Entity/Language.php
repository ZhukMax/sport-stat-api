<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LanguageRepository")
 */
class Language
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
     * @ORM\Column(type="json", nullable=true)
     */
    private $synonyms = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="language")
     */
    private $games;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GameBuffer", mappedBy="language", orphanRemoval=true)
     */
    private $gameBuffers;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->gameBuffers = new ArrayCollection();
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

    public function getSynonyms(): ?array
    {
        return $this->synonyms;
    }

    public function setSynonyms(?array $synonyms): self
    {
        $this->synonyms = $synonyms;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setLanguage($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getLanguage() === $this) {
                $game->setLanguage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GameBuffer[]
     */
    public function getGameBuffers(): Collection
    {
        return $this->gameBuffers;
    }

    public function addGameBuffer(GameBuffer $gameBuffer): self
    {
        if (!$this->gameBuffers->contains($gameBuffer)) {
            $this->gameBuffers[] = $gameBuffer;
            $gameBuffer->setLanguage($this);
        }

        return $this;
    }

    public function removeGameBuffer(GameBuffer $gameBuffer): self
    {
        if ($this->gameBuffers->contains($gameBuffer)) {
            $this->gameBuffers->removeElement($gameBuffer);
            // set the owning side to null (unless already changed)
            if ($gameBuffer->getLanguage() === $this) {
                $gameBuffer->setLanguage(null);
            }
        }

        return $this;
    }
}
