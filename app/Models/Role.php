<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'detail'
    ];

    protected $appends = ['permission_ids', 'permission_slugs'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function getPermissionIdsAttribute()
    {
        return $this->permissions->pluck('id');
    }

    public function getPermissionSlugsAttribute()
    {
        return $this->permissions->pluck('slug');
    }
}