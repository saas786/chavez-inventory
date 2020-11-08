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
	protected $appends = ['url', 'availableStock'];
	protected $hidden = ['updated_at', 'created_at'];

	//Accessors
	public function getUrlAttribute()
	{
		if ($this->image_url != null) {
			return env('AWS_CLOUDFRONT_URL') . $this->image_url;
		}
		return env('AWS_CLOUDFRONT_URL') . 'static' . $this->layoutName . '.jpg';
	}

	public function getAvailableStockAttribute()
	{
		return 10;
	}

	//Relationships
	public function keyboardComponentType()
	{
		return $this->belongsTo(KeyboardComponentType::class);
	}

	public function layout()
	{
		return $this->belongsTo(Layout::class);
	}

	public function keyboard()
	{
		switch ($this->keyboard_component_type_id) {
			case 1:
				return $this->hasOne(Keyboard::class, 'switch_id');
				break;

			case 2:
				return $this->hasOne(Keyboard::class, 'keycap_id');
				break;

			case 3:
				return $this->hasOne(Keyboard::class, 'plate_id');
				break;

			case 4:
				return $this->hasOne(Keyboard::class, 'case_id');
				break;

			default:
				return null;
				break;
		}
	}

	//Static Functions
	public static function available()
	{
		return 23;
	}
}
