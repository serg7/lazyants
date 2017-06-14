<?php

namespace LazyAnts\Bundle\FrontBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * Team
 */
class Team
{



    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $logo;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $homeGames;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->homeGames = new ArrayCollection();
        $this->awayGames = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Team
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Team
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add homeGame
     *
     * @param \LazyAnts\Bundle\FrontBundle\Entity\Game $homeGame
     *
     * @return Team
     */
    public function addHomeGame(\LazyAnts\Bundle\FrontBundle\Entity\Game $homeGame)
    {
        $this->homeGames[] = $homeGame;

        return $this;
    }

    /**
     * Remove homeGame
     *
     * @param \LazyAnts\Bundle\FrontBundle\Entity\Game $homeGame
     */
    public function removeHomeGame(\LazyAnts\Bundle\FrontBundle\Entity\Game $homeGame)
    {
        $this->homeGames->removeElement($homeGame);
    }

    /**
     * Get homeGames
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHomeGames()
    {
        return $this->homeGames;
    }


    /**
     * Get home and away games
     */
    public function getAllGames()
    {
        return new ArrayCollection(array_merge((array) $this->homeGames, (array) $this->awayGames));
    }


    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $awayGames;


    /**
     * Add awayGame
     *
     * @param \LazyAnts\Bundle\FrontBundle\Entity\Game $awayGame
     *
     * @return Team
     */
    public function addAwayGame(\LazyAnts\Bundle\FrontBundle\Entity\Game $awayGame)
    {
        $this->awayGames[] = $awayGame;

        return $this;
    }

    /**
     * Remove awayGame
     *
     * @param \LazyAnts\Bundle\FrontBundle\Entity\Game $awayGame
     */
    public function removeAwayGame(\LazyAnts\Bundle\FrontBundle\Entity\Game $awayGame)
    {
        $this->awayGames->removeElement($awayGame);
    }

    /**
     * Get awayGames
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAwayGames()
    {
        return $this->awayGames;
    }
}
