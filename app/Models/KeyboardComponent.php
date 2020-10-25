<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Throwable;

class KeyboardComponent extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['type', 'layoutName', 'url'];

    //Accessors
    public function getTypeAttribute() {
        try{
            return $this->keyboardComponentType->name;
        }
        catch( Throwable $e ){
            return null;
        }
    }

    public function getLayoutNameAttribute(){
        try{
            return $this->layout->name;
        }
        catch( Throwable $e ) {
            return null;
        }
    }

    public function getUrlAttribute(){
        if ($this->image_url != null)
            return env('AWS_CLOUDFRONT_URL').$this->image_url;
        return env('AWS_CLOUDFRONT_URL').'static'.$this->layoutName.'.jpg';
    }

    //Relationships

    public function keyboardComponentType(){
        return $this->belongsTo( KeyboardComponentType::class );
    }

    public function layout(){
        return $this->belongsTo( Layout::class);
    }

    public static function available(){
        return 25;
    }

}
