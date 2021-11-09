<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visual extends Model
{
    use HasFactory;
    protected $hidden = array('project_id', 'id', 'created_at', 'updated_at');

    public function media() {
        return $this->hasMany(Medium::class);
    }
}
