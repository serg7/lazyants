<?php

namespace LazyAnts\Bundle\FrontBundle\Controller;

use LazyAnts\Bundle\FrontBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    public function indexAction()
    {
        $teams = $this->getDoctrine()->getRepository('LazyAntsFrontBundle:Team')
            ->findAll();

        return $this->render('LazyAntsFrontBundle:Main:index.html.twig', array('teams' => $teams));
    }

    public function teamAction($name)
    {
        $request = Request::createFromGlobals();
        $team = $this->getDoctrine()->getRepository('LazyAntsFrontBundle:Team')
            ->findOneByName($name);

        $search = $request->query->get('search');

        if ($request->isMethod('GET') && !is_null($search))
        {
            $home_games = $this->getDoctrine()->getRepository('LazyAntsFrontBundle:Game')->searchAwayTeamByWord($name, $search);
        }
        else
        {
            $home_games = $team->getHomeGames();
        }

        return $this->render('LazyAntsFrontBundle:Main:team.html.twig', array('team' => $team,'games' => $home_games));
    }
}
