<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyboard extends Model
{
	use HasFactory;

	protected $guarded = [];
	protected $appends = ['price'];

	//Relationships
	public function switch()
	{
		return $this->belongsTo(KeyboardComponent::class, 'switch_id');
	}
	public function keycap()
	{
		return $this->belongsTo(KeyboardComponent::class, 'keycap_id');
	}
	public function case()
	{
		return $this->belongsTo(KeyboardComponent::class, 'case_id');
	}
	public function plate()
	{
		return $this->belongsTo(KeyboardComponent::class, 'plate_id');
	}
	public function layout()
	{
		return $this->belongsTo(Layout::class, 'layout_id');
	}
	public function cable()
	{
		return $this->belongsTo(Cable::class);
	}

	//Accessors
	public function getComponentsAttribute()
	{
		return collect([
			$this->switch,
			$this->keycap,
			$this->cable,
			$this->plate,
			$this->case,
		]);
	}

	public function getPriceAttribute()
	{
		$price = 0;
		$price += $this->switch->price;
		$price += $this->keycap->price;
		$price += $this->plate->price;
		$price += $this->case->price;

		return $price;
	}
}
