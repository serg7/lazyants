<?php

namespace LazyAnts\Bundle\FrontBundle\Entity;

/**
 * Game
 */
class Game
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $score;

    /**
     * @var \LazyAnts\Bundle\FrontBundle\Entity\Team
     */
    private $awayTeam;

    /**
     * @var \LazyAnts\Bundle\FrontBundle\Entity\Team
     */
    private $homeTeam;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Game
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set score
     *
     * @param string $score
     *
     * @return Game
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return string
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set awayTeam
     *
     * @param \LazyAnts\Bundle\FrontBundle\Entity\Team $awayTeam
     *
     * @return Game
     */
    public function setAwayTeam(\LazyAnts\Bundle\FrontBundle\Entity\Team $awayTeam = null)
    {
        $this->awayTeam = $awayTeam;

        return $this;
    }

    /**
     * Get awayTeam
     *
     * @return \LazyAnts\Bundle\FrontBundle\Entity\Team
     */
    public function getAwayTeam()
    {
        return $this->awayTeam;
    }

    /**
     * Set homeTeam
     *
     * @param \LazyAnts\Bundle\FrontBundle\Entity\Team $homeTeam
     *
     * @return Game
     */
    public function setHomeTeam(\LazyAnts\Bundle\FrontBundle\Entity\Team $homeTeam = null)
    {
        $this->homeTeam = $homeTeam;

        return $this;
    }

    /**
     * Get homeTeam
     *
     * @return \LazyAnts\Bundle\FrontBundle\Entity\Team
     */
    public function getHomeTeam()
    {
        return $this->homeTeam;
    }
}
