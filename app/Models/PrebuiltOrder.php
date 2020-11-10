<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrebuiltOrder extends Model
{
	use HasFactory;

	//Relationships
	public function order()
	{
		return $this->morphOne(Order::class, 'orderable');
	}
}
