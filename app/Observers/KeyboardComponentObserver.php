<?php

namespace App\Observers;

use App\Models\KeyboardComponent;
use Illuminate\Support\Facades\Storage;

class KeyboardComponentObserver
{
	/**
	 * Handle the keyboard component "updating" event.
	 * Deletes the previous stored image in Amazon S3
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
	 * Handle the keyboard component "deleted" event.
	 * Delete the related image in Amazon S3.
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
}
