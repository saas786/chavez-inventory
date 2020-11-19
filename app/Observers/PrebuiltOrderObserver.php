<?php

namespace App\Observers;

use App\Models\PrebuiltOrder;
use Illuminate\Support\Facades\Storage;

class PrebuiltOrderObserver
{
	/**
	 * Handle the prebuilt order "updating" event.
	 *
	 * @param  \App\Models\PrebuiltOrder  $prebuiltOrder
	 * @return void
	 */
	public function updating(PrebuiltOrder $prebuiltOrder)
	{
		if ($prebuiltOrder->isDirty('image_url')) {
			Storage::disk('s3')->delete($prebuiltOrder->getOriginal('image_url'));
		}
	}

	/**
	 * Handle the prebuilt order "deleted" event.
	 *
	 * @param  \App\Models\PrebuiltOrder  $prebuiltOrder
	 * @return void
	 */
	public function deleted(PrebuiltOrder $prebuiltOrder)
	{
		if ($prebuiltOrder->image_url != null) {
			Storage::disk('s3')->delete($prebuiltOrder->image_url);
		}
	}
}
