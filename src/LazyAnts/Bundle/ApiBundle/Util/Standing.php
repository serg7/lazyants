<?php

namespace LazyAnts\Bundle\ApiBundle\Util;

/**
 * Class Standing
 * @package LazyAnts\Bundle\ApiBundle\Util
 */
class Standing
{
    private $standings = array();

    /**
     *
     * @param $teams
     * @param $games
     * @return array
     */
    public function getStandings($teams, $games)
    {
        $this->calculateResultsForEachTeam($teams, $games)
            ->sort()
            ->addPlaceField();

        return $this->standings;
    }

    /**
     * Calculate standing result for each team
     *
     * @param $teams
     * @param $games
     * @return $this
     */
    private function calculateResultsForEachTeam($teams, $games)
    {
        foreach ($teams as $key => $team)
        {
            $team_name = $team->getName();
            $played = 0;
            $wins   = 0;
            $draws  = 0;
            $losses = 0;
            $points = 0;

            foreach ($games as $game)
            {
                if ($game['homeTeam'] == $team_name || $game['awayTeam'] == $team_name)
                {
                    $played++;
                    $score = explode(' ', $game['score']);
                    $homeScore = $score[0];
                    $awayScore = $score[2];

                    // case home game
                    if ($team_name == $game['homeTeam'])
                    {
                        if ($homeScore > $awayScore)
                        {
                            $wins++;
                            $points += 3;
                        }
                        else if ($awayScore == $awayScore)
                        {
                            $draws++;
                            $points += 1;
                        }
                        else
                        {
                            $losses++;
                        }
                    }
                    // case away game
                    else
                    {
                        if ($homeScore < $awayScore)
                        {
                            $wins++;
                            $points += 3;
                        }
                        else if ($homeScore == $awayScore)
                        {
                            $draws++;
                            $points += 1;
                        }
                        else
                        {
                            $losses++;
                        }
                    }
                }
            }

            $standing = array
            (
                'place'     =>  0,
                'team'      =>  $team_name,
                'played'    =>  $played,
                'wins'      =>  $wins,
                'draws'     =>  $draws,
                'losses'    =>  $losses,
                'points'    =>  $points
            );

            $this->standings[$key] = $standing;
        }

        return $this;
    }

    /**
     * Sort standings by 'points' param
     *
     * @return $this
     */
    private function sort()
    {
        usort($this->standings, function ($a, $b) {
            if ($a['points'] == $b['points'])
            {
                return 0;
            }

            return ($a['points'] > $b['points']) ? -1 : 1;
        });

        return $this;
    }

    /**
     * Add 'place' field for each standing
     *
     * @return array
     */

    private function addPlaceField()
    {
        foreach ($this->standings as $key => $standing)
        {
            $standing['place'] = $key + 1;
            $this->standings[$key] = $standing;
        }
    }


}