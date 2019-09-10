<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SportTypeRepository")
 */
class SportType
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
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="sport", orphanRemoval=true)
     */
    private $games;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SportTeam", mappedBy="sport")
     */
    private $sportTeams;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GameBuffer", mappedBy="sport", orphanRemoval=true)
     */
    private $gameBuffers;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->sportTeams = new ArrayCollection();
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
            $game->setSport($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getSport() === $this) {
                $game->setSport(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SportTeam[]
     */
    public function getSportTeams(): Collection
    {
        return $this->sportTeams;
    }

    public function addSportTeam(SportTeam $sportTeam): self
    {
        if (!$this->sportTeams->contains($sportTeam)) {
            $this->sportTeams[] = $sportTeam;
            $sportTeam->setSport($this);
        }

        return $this;
    }

    public function removeSportTeam(SportTeam $sportTeam): self
    {
        if ($this->sportTeams->contains($sportTeam)) {
            $this->sportTeams->removeElement($sportTeam);
            // set the owning side to null (unless already changed)
            if ($sportTeam->getSport() === $this) {
                $sportTeam->setSport(null);
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
            $gameBuffer->setSport($this);
        }

        return $this;
    }

    public function removeGameBuffer(GameBuffer $gameBuffer): self
    {
        if ($this->gameBuffers->contains($gameBuffer)) {
            $this->gameBuffers->removeElement($gameBuffer);
            // set the owning side to null (unless already changed)
            if ($gameBuffer->getSport() === $this) {
                $gameBuffer->setSport(null);
            }
        }

        return $this;
    }
}
