<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser // <-- Add "implements FilamentUser"
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
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

    public function colleagues()
    {
    // This finds all Users where their 'company_id' matches this user's 'company_id',
    // excluding the user themselves from the list.
    return $this->hasMany(User::class, 'company_id', 'company_id')
                ->where('id', '!=', $this->id);
    }

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
    // Allow access only if the user's role is 'Super Admin' or 'Manager'
    return in_array($this->role, ['Super Admin', 'Manager']);
    }

}
