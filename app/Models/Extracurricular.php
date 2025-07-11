<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Extracurricular extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'contacts' => 'array',
        'galleries' => 'json',
        'staff' => 'array',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function booted()
    {
        static::updating(function ($extracurricular) {
            // Hapus logo lama jika berubah dan bukan default
            if ($extracurricular->isDirty('logo')) {
                $oldLogo = $extracurricular->getOriginal('logo');
                if ($oldLogo && $oldLogo !== '/default/extracurricular.svg') {
                    Storage::disk('public')->delete($oldLogo);
                }
            }

            // Hapus galleries yang dihapus dari array
            $originalGalleries = $extracurricular->getOriginal('galleries') ?? [];
            $newGalleries = $extracurricular->galleries ?? [];

            $filesToDelete = array_diff($originalGalleries, $newGalleries);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }

            // Hapus photo staff yang dihapus
            $originalStaff = $extracurricular->getOriginal('staff') ?? [];
            $newStaff = $extracurricular->staff ?? [];

            $originalPhotos = collect($originalStaff)->pluck('photo')->filter()->toArray();
            $newPhotos = collect($newStaff)->pluck('photo')->filter()->toArray();

            $filesToDelete = array_diff($originalPhotos, $newPhotos);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }

            // Hapus attachment yang dihapus dari description
            $originalDescription = $extracurricular->getOriginal('description');
            $newDescription = $extracurricular->description;

            preg_match_all('/extracurriculars\/[^"\']+/', $originalDescription, $originalFiles);
            preg_match_all('/extracurriculars\/[^"\']+/', $newDescription, $newFiles);

            $filesToDelete = array_diff($originalFiles[0] ?? [], $newFiles[0] ?? []);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });

        static::deleting(function ($extracurricular) {
            // Hapus logo jika bukan default
            if ($extracurricular->logo && $extracurricular->logo !== '/default/extracurricular.svg') {
                Storage::disk('public')->delete($extracurricular->logo);
            }

            // Hapus semua galleries
            if ($extracurricular->galleries) {
                foreach ($extracurricular->galleries as $file) {
                    Storage::disk('public')->delete($file);
                }
            }

            // Hapus semua photo staff
            if ($extracurricular->staff) {
                foreach ($extracurricular->staff as $staff) {
                    if (!empty($staff['photo'])) {
                        Storage::disk('public')->delete($staff['photo']);
                    }
                }
            }

            // Hapus semua attachment dari description
            preg_match_all('/extracurriculars\/[^"\']+/', $extracurricular->description, $files);
            foreach ($files[0] ?? [] as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    }
    // protected static function booted()
    // {
    //     // logo
    //     static::deleting(function ($extracurricular) {
    //         if ($extracurricular->logo && $extracurricular->logo !== '/default/extracurricular.svg') {
    //             Storage::disk('public')->delete($extracurricular->logo);
    //         }
    //     });
    
    //     static::updating(function ($extracurricular) {
    //         if ($extracurricular->isDirty('logo')) {
    //             $oldLogo = $extracurricular->getOriginal('logo');
    //             if ($oldLogo && $extracurricular->logo !== '/default/extracurricular.svg') {
    //                 Storage::disk('public')->delete($oldLogo);
    //             }
    //         }
    //     });
    //     // logo

    //     // galleries
    //     static::deleting(function ($extracurricular) {
    //         if ($extracurricular->galleries) {
    //             foreach ($extracurricular->galleries as $file) {
    //                 Storage::disk('public')->delete($file);
    //             }
    //         }
    //     });
    
    //     static::updating(function ($extracurricular) {
    //         $originalGalleries = $extracurricular->getOriginal('galleries') ?? [];
    //         $newGalleries = $extracurricular->galleries ?? [];
    
    //         $filesToDelete = array_diff($originalGalleries, $newGalleries);
    
    //         foreach ($filesToDelete as $file) {
    //             Storage::disk('public')->delete($file);
    //         }
    //     });
    //     // galleries

    //     // staff
    //     static::deleting(function ($extracurricular) {
    //         if ($extracurricular->staff) {
    //             foreach ($extracurricular->staff as $file) {
    //                 Storage::disk('public')->delete($file);
    //             }
    //         }
    //     });
    
    //     static::updating(function ($extracurricular) {
    //         $originalStaff = $extracurricular->getOriginal('staff') ?? [];
    //         $newStaff = $extracurricular->staff ?? [];
    
    //         $filesToDelete = array_diff($originalStaff, $newStaff);
    
    //         foreach ($filesToDelete as $file) {
    //             Storage::disk('public')->delete($file);
    //         }
    //     });
    //     // staff

    //     // attachment
    //     static::updating(function ($extracurricular) {
    //         $originaldescription = $extracurricular->getOriginal('content');
    //         $newContent = $extracurricular->content;

    //         // ambil semua path file yang berada di folder extracurriculars/... (termasuk subfolder)
    //         preg_match_all('/extracurriculars\/[^"\']+/', $originalContent, $originalFiles);
    //         preg_match_all('/extracurriculars\/[^"\']+/', $newContent, $newFiles);

    //         $filesToDelete = array_diff($originalFiles[0] ?? [], $newFiles[0] ?? []);

    //         foreach ($filesToDelete as $file) {
    //             Storage::disk('public')->delete($file);
    //         }
    //     });

    //     static::deleting(function ($extracurricular) {
    //         // Hapus semua file yang ada di konten saat record dihapus
    //         preg_match_all('/extracurriculars\/[^"\']+/', $extracurricular->content, $files);

    //         foreach ($files[0] ?? [] as $file) {
    //             Storage::disk('public')->delete($file);
    //         }
    //     });
    //     // attachment
    // }   
}
