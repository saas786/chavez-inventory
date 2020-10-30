<?php

namespace App\Observers;

use App\Models\KeyboardComponent;
use Illuminate\Support\Facades\Storage;

class KeyboardComponentObserver
{
	/**
	 * Handle the keyboard component "created" event.
	 *
	 * @param  \App\Models\KeyboardComponent  $keyboardComponent
	 * @return void
	 */
	public function created(KeyboardComponent $keyboardComponent)
	{
		if ($keyboardComponent->keyboard_component_type_id <= 2) {
			$keyboardComponent->layout_id = null;
			$keyboardComponent->saveQuietly();
		}
	}

	/**
	 * Handle the keyboard component "updating" event.
	 *
	 * @param  \App\Models\KeyboardComponent  $keyboardComponent
	 * @return void
	 */
	public function updating(KeyboardComponent $keyboardComponent)
	{
		if ($keyboardComponent->isDirty('image_url')) {
			Storage::disk('s3')->delete($keyboardComponent->getOriginal('image_url'));
		}
	}

	/**
	 * Handle the keyboard component "updated" event.
	 *
	 * @param  \App\Models\KeyboardComponent  $keyboardComponent
	 * @return void
	 */
	public function updated(KeyboardComponent $keyboardComponent)
	{
		if ($keyboardComponent->keyboard_component_type_id <= 2) {
			$keyboardComponent->layout_id = null;
			$keyboardComponent->saveQuietly();
		}
	}

	/**
	 * Handle the keyboard component "deleted" event.
	 *
	 * @param  \App\Models\KeyboardComponent  $keyboardComponent
	 * @return void
	 */
	public function deleted(KeyboardComponent $keyboardComponent)
	{
		if ($keyboardComponent->image_url != null) {
			Storage::disk('s3')->delete($keyboardComponent->image_url);
		}
	}

	/**
	 * Handle the keyboard component "restored" event.
	 *
	 * @param  \App\Models\KeyboardComponent  $keyboardComponent
	 * @return void
	 */
	public function restored(KeyboardComponent $keyboardComponent)
	{
		//
	}

	/**
	 * Handle the keyboard component "force deleted" event.
	 *
	 * @param  \App\Models\KeyboardComponent  $keyboardComponent
	 * @return void
	 */
	public function forceDeleted(KeyboardComponent $keyboardComponent)
	{
		//
	}
}
