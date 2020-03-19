<?php


namespace TitarLab\Analytics;


use TitarLab\Analytics\Structures\Response;
use TitarLab\Analytics\Structures\TotalResponse;

class Analytics
{
    public function __construct($token)
    {
        $this->token = $token;
        $this->endpoint = "https://analytics.titarlab.com/api";
        $this->version = "v1";
    }

    public function getInfo($dateFormat, $dateFrom, $dateTo){
        $client = new \GuzzleHttp\Client();
        $analyticResponse = $client->get($this->endpoint."/".$this->version."/info/".$this->token."?dateFormat=$dateFormat&dateFrom=$dateFrom&dateTo=$dateTo");
        $content = json_decode($analyticResponse->getBody());
        $response = new Response($content->data->sessions, $content->data->pageViews, $content->data->visits, new TotalResponse($content->data->total->sessions, $content->data->total->pageViews, $content->data->total->users));
        return $response;
    }
}