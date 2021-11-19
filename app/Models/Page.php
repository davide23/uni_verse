<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\Console\Output\ConsoleOutput;

class Page extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $hidden = array('cube_id', 'id', 'created_at', 'updated_at');
    protected $appends = array('background_visual');

    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(130)
            ->height(130);
    }

    public function getBackgroundVisualAttribute() {
        return $this->getMedia('background_visual')[0]->getFullUrl();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('background_visual')->singleFile();
    }
}
