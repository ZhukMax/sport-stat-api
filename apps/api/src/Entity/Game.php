<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Source", inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $source;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\League", inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $league;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SportType", inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $sport;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SportTeam", inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $teamOne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SportTeam")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $teamTwo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Language", inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Language
     */
    private $language;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GameBuffer", mappedBy="baseGame")
     */
    private $gameBuffers;

    public function __construct()
    {
        $this->gameBuffers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getSource(): ?Source
    {
        return $this->source;
    }

    public function setSource(?Source $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getLeague(): ?League
    {
        return $this->league;
    }

    public function setLeague(?League $league): self
    {
        $this->league = $league;

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

    public function getTeamOne(): ?SportTeam
    {
        return $this->teamOne;
    }

    public function setTeamOne(?SportTeam $teamOne): self
    {
        $this->teamOne = $teamOne;

        return $this;
    }

    public function getTeamTwo(): ?SportTeam
    {
        return $this->teamTwo;
    }

    public function setTeamTwo(?SportTeam $teamTwo): self
    {
        $this->teamTwo = $teamTwo;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

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
            $gameBuffer->setBaseGame($this);
        }

        return $this;
    }

    public function removeGameBuffer(GameBuffer $gameBuffer): self
    {
        if ($this->gameBuffers->contains($gameBuffer)) {
            $this->gameBuffers->removeElement($gameBuffer);
            // set the owning side to null (unless already changed)
            if ($gameBuffer->getBaseGame() === $this) {
                $gameBuffer->setBaseGame(null);
            }
        }

        return $this;
    }
}
