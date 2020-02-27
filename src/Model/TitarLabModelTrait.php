<?php


namespace TitarLab\Model;


trait TitarLabModelTrait
{
    public function showList($array){
        $list = [];
        foreach ($array as $item){
            $list[] = $this->show($item);
        }
        return $list;
    }
}