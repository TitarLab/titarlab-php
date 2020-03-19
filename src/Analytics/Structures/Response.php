<?php


namespace TitarLab\Analytics\Structures;


class Response
{
    public $sessions = 0;
    public $pageViews = 0;
    public $visits = 0;
    /** @var TotalResponse $total */
    public $total;

    public function __construct(int $sessions, int $pageViews, int $visits, TotalResponse $total)
    {
        $this->sessions = $sessions;
        $this->pageViews = $pageViews;
        $this->visits = $visits;
        $this->total = $total;
    }
}