<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Storage extends Model
{
    use HasFactory;
    use Uuid;

    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable = [
        'file_name',
        'file_path',
        'file_size',
        'file_type',
        'file_extension',
        'file_mime',
        'file_url',
    ];
}
