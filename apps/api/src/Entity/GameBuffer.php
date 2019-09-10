<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameBufferRepository")
 */
class GameBuffer
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Source", inversedBy="gameBuffers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $source;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\League", inversedBy="gameBuffers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $league;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SportType", inversedBy="gameBuffers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sport;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SportTeam", inversedBy="gameBuffers")
     */
    private $teamOne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SportTeam", inversedBy="gameBuffers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teamTwo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Language", inversedBy="gameBuffers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="gameBuffers")
     */
    private $baseGame;

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

    public function getBaseGame(): ?Game
    {
        return $this->baseGame;
    }

    public function setBaseGame(?Game $baseGame): self
    {
        $this->baseGame = $baseGame;

        return $this;
    }
}
