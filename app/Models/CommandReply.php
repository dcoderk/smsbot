<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandReply extends Model
{
    use HasFactory;

    protected $fillable = ['command_id', 'type', 'content'];

    public function command()
    {
        return $this->belongsTo(Command::class);
    }
}
