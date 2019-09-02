<?php
/**
 * Created by PhpStorm.
 * User: papesambandour
 * Date: 2019-06-04
 * Time: 15:11
 */
$xml = new SimpleXMLElement('<root/>');
$data = ['as'=>'df','ed'=>'dsd'];
//$fliped = array_flip($data);

//array_walk_recursive($fliped, array ($xml, 'addChild'));
array_walk_recursive($data,function ($value,$key) use (&$xml){
    $xml->addChild($key,$value);
});
//die($xml->asXML());

//array_walk_recursive($fruits,function ($value,$key){echo 'valll---'.$value."\n" ;});
function papa2(){
    echo  'khk';
}
$pape = papa2 ;

$pape();
?>