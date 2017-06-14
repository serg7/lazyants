<?php

namespace LazyAnts\Bundle\FrontBundle\Command;

use LazyAnts\Bundle\FrontBundle\Entity\Game;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class ParseResultsCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('parse-results')
            ->setDescription('Fetching game results from soccerway.com');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = array();
        $buzz = $this->getApplication()->getKernel()->getContainer()->get('buzz');  // TODO: hope there is better way to get it

        for ($i = 0; $i <= 12; $i++)
        {
            $page_number = urlencode('{"page":-' . $i . '}');
            $url = 'http://int.soccerway.com/a/block_competition_matches?'.  'params=' . $page_number . '&block_id=page_competition_1_block_competition_matches_7&callback_params=%7B%22page%22%3A%22-1%22%2C%22bookmaker_urls%22%3A%7B%2213%22%3A%5B%7B%22link%22%3A%22http%3A%2F%2Fwww.bet365.com%2Fhome%2F%3Faffiliate%3D365_179024%22%2C%22name%22%3A%22Bet%20365%22%7D%5D%7D%2C%22block_service_id%22%3A%22competition_matches_block_competitionmatches%22%2C%22round_id%22%3A%2214829%22%2C%22outgroup%22%3A%22%22%2C%22view%22%3A%222%22%7D&action=changePage';
            $page = stripslashes($buzz->get($url)->getContent());
            $crawler = new Crawler($page);

            $temp_result = $crawler->filter('tbody tr')->each(function (Crawler $node) {
                return array(
                    'date' => $node->filter('td.date')->text(),
                    'score' => $node->filter('td.score')->text(),
                    'home' => $node->filter('td.team-a a')->attr('title'),
                    'away' => $node->filter('td.team-b a')->attr('title'),
                );
            });

            $result = array_merge($result, $temp_result);
        }

        $result = $this->saveGameResults($result);

        $output->writeln(array(
                '<info>Successfully parsed. Total successfully fetched matches: ' . $result['success'] . '</info>',
            ));

        if (count($result['errors']) > 0)
        {
            $this->displayErrors($result['errors']);
        }

    }

    private function saveGameResults($data)
    {
        $em = $this->getApplication()->getKernel()->getContainer()->get('doctrine')->getManager();
        $team_repo = $em->getRepository('LazyAntsFrontBundle:Team');

        $errors = array();

        foreach ($data as $game)
        {
            $home_team = $team_repo->findTeamByName($game['home']);
            $away_team = $team_repo->findTeamByName($game['away']);

            if (!is_null($home_team) && !is_null($away_team))
            {
                $gameObj = new Game();
                $gameObj->setScore($game['score']);
                $date = \DateTime::createFromFormat('d/m/y', $game['date']);
                $gameObj->setDate(new \DateTime($date->format('Y-m-d')));
                $gameObj->setHomeTeam($home_team);
                $gameObj->setAwayTeam($away_team);
                $em->persist($gameObj);
            }
            else
            {
                $errors[] = $game;
            }
        }

        $em->flush();

        return array(
                'success' => count($data) - count($errors),
                'errors'  => $errors
            );
    }

    private function displayErrors($errors)
    {
        $output = new ConsoleOutput();
        $output->writeln('<error>Next games were not saved. There are some problems with team names: </error>');

        foreach ($errors as $error)
        {
            $output->writeln($error['date'] . ' ' . $error['home'] . ' - ' . $error['away'] . ' ' . $error['score']);
        }
    }
}