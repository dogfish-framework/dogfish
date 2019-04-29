<?php
/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 25/03/2018
 * Time: 16:18
 */

namespace App\model;


use DogfishCore\Model;

class User extends Model
{
    protected $table = "users"; //par defaut il prent le nom de la classe qu'il met au pluriel et au au minuscule
    protected $guarded = [];
    public $timestamps = false;//pour igonrer les
}