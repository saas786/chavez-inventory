<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cable extends Model
{
	use HasFactory;

	protected $guarded = [];

	//Relationships
	public function color()
	{
		return $this->belongsTo(Color::class);
	}
	public function double_sleeve_color()
	{
		return $this->belongsTo(Color::class, 'double_sleeve_color_id');
	}
}
