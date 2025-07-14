<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    protected $fillable = ['trigger', 'description', 'company_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function replies()
    {
        return $this->hasMany(CommandReply::class);
    }
}
