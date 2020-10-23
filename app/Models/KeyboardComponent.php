<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyboardComponent extends Model
{
    use HasFactory;

    public static function available(){
        return 25;
    }

}
