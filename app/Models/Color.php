<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
	use HasFactory;
	use SoftDeletes;

	protected $guarded = [];

	//Static Functions
	public static function colorUpdate($colors)
	{
		foreach (Color::all() as $color) {
			$color->delete();
		}

		foreach ($colors as $color) {
			$color_model = Color::withTrashed()->updateOrCreate(
				[
					'name' => $color['name'],
				],
				$color
			);
			if ($color_model->trashed()) {
				$color_model->restore();
			}
		}
	}
}
