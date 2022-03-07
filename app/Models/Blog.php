<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Blog extends Model
{
    use HasFactory, Uuid;
    
    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'image',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

}
