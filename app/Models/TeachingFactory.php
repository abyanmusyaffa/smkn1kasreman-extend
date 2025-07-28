<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeachingFactory extends Model
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
        static::updating(function ($teachingFactory) {
            // Hapus logo lama jika berubah dan bukan default
            if ($teachingFactory->isDirty('logo')) {
                $oldLogo = $teachingFactory->getOriginal('logo');
                if ($oldLogo && $oldLogo !== '/default/logo.svg') {
                    Storage::disk('public')->delete($oldLogo);
                }
            }

            // Hapus galleries yang dihapus dari array
            $originalGalleries = $teachingFactory->getOriginal('galleries') ?? [];
            $newGalleries = $teachingFactory->galleries ?? [];

            $filesToDelete = array_diff($originalGalleries, $newGalleries);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }

            // Hapus photo products yang dihapus
            $originalProducts = $teachingFactory->getOriginal('products') ?? [];
            $newProducts = $teachingFactory->products ?? [];

            $originalPhotos = collect($originalProducts)->pluck('photo')->filter()->toArray();
            $newPhotos = collect($newProducts)->pluck('photo')->filter()->toArray();

            $filesToDelete = array_diff($originalPhotos, $newPhotos);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });

        static::deleting(function ($teachingFactory) {
            // Hapus logo jika bukan default
            if ($teachingFactory->logo && $teachingFactory->logo !== '/default/logo.svg') {
                Storage::disk('public')->delete($teachingFactory->logo);
            }

            // Hapus semua galleries
            if ($teachingFactory->galleries) {
                foreach ($teachingFactory->galleries as $file) {
                    Storage::disk('public')->delete($file);
                }
            }

            // Hapus semua photo products
            if ($teachingFactory->products) {
                foreach ($teachingFactory->products as $products) {
                    if (!empty($products['photo'])) {
                        Storage::disk('public')->delete($products['photo']);
                    }
                }
            }
        });
    }
}
