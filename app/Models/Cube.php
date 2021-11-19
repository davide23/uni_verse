<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cube extends Model
{
    use HasFactory;
    protected $hidden = array('id', 'created_at', 'updated_at');

    public function pages() {
        return $this->hasMany(Page::class);
    }

    public function generateJson() {
        return $this->with([
            'pages',
            'pages.projects',
            'pages.projects.visuals',
            'pages.projects.visuals.mediumObjects'
        ])->get()->toJson();
    }
}
