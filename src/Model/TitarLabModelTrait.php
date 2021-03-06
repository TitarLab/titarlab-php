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

    public static function show($array){
        return self::createFromPropertys();
    }

    public function createFromPropertys(){
        $object = new \stdClass();
        foreach ($this->propertys as $property){
            $object->{$property} = $this->{$property};
        }
        return $object;
    }
}