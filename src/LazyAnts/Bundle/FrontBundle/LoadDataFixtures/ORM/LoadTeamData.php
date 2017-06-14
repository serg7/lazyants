<?php

namespace LazyAnts\Bundle\FrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use LazyAnts\Bundle\FrontBundle\Entity\Team;


class LoadTeamData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $teams = array(
            'Swansea City',
            'West Bromwich Albion',
            'Norwich City',
            'Aston Villa',
            'Wolverhampton Wanderers',
            'Liverpool',
            'Chelsea',
            'Queens Park Rangers',
            'Tottenham Hotspurs',
            'Blackburn Rovers',
            'Manchester City',
            'Manchester United',
            'Fulham',
            'Stoke City',
            'Everton',
            'Newcastle United',
            'Arsenal',
            'Sunderland',
            'Wigan Athletic',
            'Bolton Wanderers'
        );

        // bulk insertion
        foreach ($teams as $name) {
            $team = new Team();
            $team->setName($name);
            $team->setLogo('');

            $manager->persist($team);
        }

        $manager->flush();
        $manager->clear();
    }
}