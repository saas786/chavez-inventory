<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	use HasFactory;

	protected $guarded = [];

	//Accessors
	public function type()
	{
		return is_a($this->orderable, 'App\Models\PrebuiltOrder')
			? "Prebuilt"
			: "Custom";
	}

	//Relationships
	public function orderable()
	{
		return $this->morphTo();
	}

	public static function updateById($ids, $status)
	{
		foreach ($ids as $id) {
			$order = Order::findOrFail($id);
			$order->status = $status;
			$order->save();
		}
	}
}
