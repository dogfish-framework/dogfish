<?php
/**
 * Created by PhpStorm.
 * User: papesambandour
 * Date: 2019-04-29
 * Time: 00:55
 */
use DogfishCore\routes\Routing as Route;


Route::get('/','HomeController@index')->middleware(['LogActivity@log']);
Route::get('diaz/{pape}',function ($diapp){
    echo "PACO : ". $diapp;
});
Route::get('/public',function (){
    echo "public";
});