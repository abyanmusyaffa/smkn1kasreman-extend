<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use App\Models\Achievement;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function majors(): HasMany
    {
        return $this->hasMany(Major::class);
    }

    public function internships(): HasMany
    {
        return $this->hasMany(Internship::class);
    }

    public function extracurriculars(): HasMany
    {
        return $this->hasMany(Extracurricular::class);
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class);
    }
    
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function jobfairs(): HasMany
    {
        return $this->hasMany(Jobfair::class);
    }

    public function teaching_factories(): HasMany
    {
        return $this->hasMany(TeachingFactory::class);
    }

    public function business_units(): HasMany
    {
        return $this->hasMany(BusinessUnit::class);
    }

    public function school_departments(): HasMany
    {
        return $this->hasMany(SchoolDepartment::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    // public function alumnis(): HasOne
    // {
    //     return $this->hasOne(Alumni::class);
    // }
}
