<?php
/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 21/03/2018
 * Time: 21:12
 */

namespace DogfishCore;




class Model extends \Illuminate\Database\Eloquent\Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}