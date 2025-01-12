<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'name',
        'route',
        'icon',
        'permission_name',
        'parent_id',
        'is_dropdown',
    ];

    public function children()
    {
        return $this->hasMany(Section::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Section::class, 'parent_id');
    }
}
