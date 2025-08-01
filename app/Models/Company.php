<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_name',
        'address',
        'telephone',
    ];

    public function commands()
    {
        return $this->hasMany(Command::class);
    }
    
    public function users()
    {
        return $this->hasMany(User::class);
    }

}