<?php


namespace TitarLab\JSON;


class Meta
{
    public $page;
    public $totalItems;
    public $totalPages;
    public $perPage;

    public function __construct($page, $perPage, $totalPages, $totalItems)
    {
        $this->page = $page;
        $this->perPage = $perPage;
        $this->totalPages = $totalPages;
        $this->totalItems = $totalItems;
    }
}