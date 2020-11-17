<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrebuiltOrder extends Model
{
	use HasFactory;
	protected $guarded = [];
	protected $appends = ['url'];

	//Accessors
	public function getUrlAttribute()
	{
		if ($this->image_url != null) {
			return env('AWS_CLOUDFRONT_URL') . $this->image_url;
		}
		return null;
	}

	//Relationships
	public function order()
	{
		return $this->morphOne(Order::class, 'orderable');
	}

	public function keyboard()
	{
		return $this->belongsTo(Keyboard::class);
	}

	// Static functions
	public static function deleteMultiple($ids)
	{
		foreach ($ids as $id) {
			PrebuiltOrder::find($id)->delete();
		}
	}
}
