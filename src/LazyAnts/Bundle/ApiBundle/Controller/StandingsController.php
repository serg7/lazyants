<?php

namespace LazyAnts\Bundle\ApiBundle\Controller;

use LazyAnts\Bundle\ApiBundle\Util\Helper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use LazyAnts\Bundle\ApiBundle\Util\Standing;


class StandingsController extends Controller
{
    public function indexAction()
    {
        $request = Request::createFromGlobals();
        $from = $request->query->get('from');
        $to = $request->query->get('to');

        if (!is_null($from) && !Helper::validateDateByFormat($from))
        {
            return new JsonResponse(array('error' => 'FROM parameter has invalid format. Correct one is Y-m-d'));
        }

        if (!is_null($to) && !Helper::validateDateByFormat($to))
        {
            return new JsonResponse(array('error' => 'TO parameter has invalid format. Correct one is Y-m-d'));
        }

        $games = $this->getDoctrine()->getRepository('LazyAntsFrontBundle:Game')
            ->getGamesWithDateRange($from, $to);
        $teams = $this->getDoctrine()->getRepository('LazyAntsFrontBundle:Team')
            ->findAll();

        $data = (new Standing())->getStandings($teams, $games);

        $response = new JsonResponse(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }





}

