<?php


namespace TitarLab\JSON;


class Response
{
    public function __construct($code, $data, $message)
    {
        $this->code = $code;
        $this->data = $data;
        $this->message = $message;
    }
}