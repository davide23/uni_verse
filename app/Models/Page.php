<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Page extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $hidden = array('cube_id', 'id', 'created_at', 'updated_at');
    protected $appends = array('background_visual');

    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function getBackgroundVisualAttribute() {
        $media = $this->getFirstMedia('background_visual_object');
        if ($media)
            return $media->getFullUrl();

        return $media;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(130)
            ->height(130);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('background_visual_object')->singleFile();
    }
}
