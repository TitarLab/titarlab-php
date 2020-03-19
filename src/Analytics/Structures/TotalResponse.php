<?php


namespace TitarLab\Analytics\Structures;


class TotalResponse
{
    public $sessions = 0;
    public $pageViews = 0;
    public $users = 0;

    public function __construct(int $sessions, int $pageViews, int $users)
    {
        $this->sessions = $sessions;
        $this->pageViews = $pageViews;
        $this->users = $users;
    }
}