<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomOrder extends Model
{
	use HasFactory;

	protected $guarded = [];

	//Relationships
	public function order()
	{
		return $this->morphOne(Order::class, 'orderable');
	}

	public function keyboard()
	{
		return $this->belongsTo(Keyboard::class);
	}
}
