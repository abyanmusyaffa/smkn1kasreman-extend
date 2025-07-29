<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessUnit extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'contacts' => 'array',
        'products' => 'array',
        'services' => 'json',
        'galleries' => 'json',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function booted()
    {
        static::updating(function ($businessUnit) {
            // Hapus logo lama jika berubah dan bukan default
            if ($businessUnit->isDirty('logo')) {
                $oldLogo = $businessUnit->getOriginal('logo');
                if ($oldLogo && $oldLogo !== '/default/logo.svg') {
                    Storage::disk('public')->delete($oldLogo);
                }
            }

            // Hapus galleries yang dihapus dari array
            $originalGalleries = $businessUnit->getOriginal('galleries') ?? [];
            $newGalleries = $businessUnit->galleries ?? [];

            $filesToDelete = array_diff($originalGalleries, $newGalleries);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }

            // Hapus photo products yang dihapus
            $originalProducts = $businessUnit->getOriginal('products') ?? [];
            $newProducts = $businessUnit->products ?? [];

            $originalPhotos = collect($originalProducts)->pluck('photo')->filter()->toArray();
            $newPhotos = collect($newProducts)->pluck('photo')->filter()->toArray();

            $filesToDelete = array_diff($originalPhotos, $newPhotos);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });

        static::deleting(function ($businessUnit) {
            // Hapus logo jika bukan default
            if ($businessUnit->logo && $businessUnit->logo !== '/default/logo.svg') {
                Storage::disk('public')->delete($businessUnit->logo);
            }

            // Hapus semua galleries
            if ($businessUnit->galleries) {
                foreach ($businessUnit->galleries as $file) {
                    Storage::disk('public')->delete($file);
                }
            }

            // Hapus semua photo products
            if ($businessUnit->products) {
                foreach ($businessUnit->products as $products) {
                    if (!empty($products['photo'])) {
                        Storage::disk('public')->delete($products['photo']);
                    }
                }
            }
        });
    }
}
