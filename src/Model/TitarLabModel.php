<?php


namespace TitarLab\Model;


trait TitarLabModel
{
    abstract protected function show($item);

    protected function showList($array){
        $list = [];
        foreach ($array as $item){
            $list[] = $this->show($item);
        }
        return $list;
    }

}