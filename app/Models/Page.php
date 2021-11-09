<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $hidden = array('cube_id', 'id', 'created_at', 'updated_at');

    public function projects() {
        return $this->hasMany(Project::class);
    }
}
