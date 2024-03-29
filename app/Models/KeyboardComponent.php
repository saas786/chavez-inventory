<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class KeyboardComponent extends Model
{
	use HasFactory;

	protected $guarded = [];
	protected $appends = ['url', 'availableStock'];
	protected $hidden = ['updated_at', 'created_at'];

	//Accessors

	/**
	 * Accessor for the url attribute.
	 * Gets the url for the AWS Cloudfront server.
	 * If no image is assinged, then retrieve the default static image.
	 *
	 * @return String
	 */
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

	/**
	 * Return a collection of components that are
	 * grouped into their separate categories.
	 *
	 * @param boolean $encrypted
	 * @return Collection
	 */
	public static function categorizedComponents($encrypted)
	{
		return KeyboardComponent::with(['layout', 'keyboardComponentType'])
			->get()
			->sortBy('keyboard_component_type_id')
			->groupBy('keyboard_component_type_id')
			->map(function ($collection) use ($encrypted) {
				return $collection
					->sortBy('price')
					->map(function ($comp) use ($encrypted) {
						return [
							'id' => $encrypted ? Crypt::encrypt($comp->id) : $comp->id,
							'name' => $comp->name,
							'price' => $comp->price,
							'layout_id' => $comp->layout_id,
							'stock' => $comp->availableStock,
							'url' => $comp->url,
						];
					})
					->where('stock', '>', 0)
					->values();
			})
			->values();
	}

	public static function available()
	{
		return 23;
	}

	public static function deleteById($ids)
	{
		foreach ($ids as $id) {
			$component = KeyboardComponent::findOrFail($id);
			$component->delete();
		}
	}

	public static function stockById($ids, $stock)
	{
		foreach ($ids as $id) {
			$component = KeyboardComponent::findOrFail($id);
			$component->stock += $stock;
			$component->save();
		}
	}
}
