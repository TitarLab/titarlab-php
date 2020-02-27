<?php


namespace TitarLab\Model;


trait TitarLabModelTrait
{
    public static function showList($array){
        $list = [];
        foreach ($array as $item){
            $list[] = self::show($item);
        }
        return $list;
    }
}