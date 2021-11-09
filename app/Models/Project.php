<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $hidden = array('page_id', 'id', 'created_at', 'updated_at');

    public function visuals() {
        return $this->hasMany(Visual::class);
    }
}
