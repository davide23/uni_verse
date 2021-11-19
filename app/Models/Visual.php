<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visual extends Model
{
    use HasFactory;
    protected $hidden = array('project_id', 'id', 'created_at', 'updated_at');

    public function mediumobjects() {
        return $this->hasMany(MediumObject::class);
    }
}
