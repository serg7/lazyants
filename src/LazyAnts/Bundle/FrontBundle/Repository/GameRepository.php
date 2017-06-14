<?php

namespace LazyAnts\Bundle\FrontBundle\Repository;
use Doctrine\ORM\EntityRepository;


class GameRepository extends EntityRepository
{
    public function searchAwayTeamByWord($home, $search)
    {
        $result = $this->createQueryBuilder('game')
            ->leftJoin('game.homeTeam', 'home')
            ->leftJoin('game.awayTeam', 'away' )
            ->where('home.name = :homeTeam')
            ->andWhere('away.name LIKE :awayTeam')
            ->setParameter('awayTeam', '%'. $search .'%')
            ->setParameter('homeTeam', $home)
            ->getQuery()
            ->getResult();

        return $result;
    }

    public function getGamesWithDateRange($from = null, $to = null)
    {
        $qb = $this->createQueryBuilder('game')
            ->leftJoin('game.homeTeam', 'home')
            ->leftJoin('game.awayTeam', 'away')
            ->select('home.name AS homeTeam, away.name AS awayTeam, game.score AS score, game.date');

        if (!is_null($from))
        {
            $qb->andWhere('game.date > :from')
               ->setParameter('from', $from);
        }

        if (!is_null($to))
        {
            $qb->andWhere('game.date < :to')
                ->setParameter('to', $to);
        }

        $games = $qb->getQuery()->getArrayResult();

        return $games;
    }



}
