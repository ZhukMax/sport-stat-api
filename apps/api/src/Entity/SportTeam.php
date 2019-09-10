<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SportTeamRepository")
 */
class SportTeam
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SportType", inversedBy="sportTeams")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $sport;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Assert\Json(message = "Invalid Json.")
     */
    private $synonyms = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="teamOne", orphanRemoval=true)
     */
    private $games;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GameBuffer", mappedBy="teamOne")
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

    public function getSport(): ?SportType
    {
        return $this->sport;
    }

    public function setSport(?SportType $sport): self
    {
        $this->sport = $sport;

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
            $game->setTeamOne($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getTeamOne() === $this) {
                $game->setTeamOne(null);
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
            $gameBuffer->setTeamOne($this);
        }

        return $this;
    }

    public function removeGameBuffer(GameBuffer $gameBuffer): self
    {
        if ($this->gameBuffers->contains($gameBuffer)) {
            $this->gameBuffers->removeElement($gameBuffer);
            // set the owning side to null (unless already changed)
            if ($gameBuffer->getTeamOne() === $this) {
                $gameBuffer->setTeamOne(null);
            }
        }

        return $this;
    }
}
