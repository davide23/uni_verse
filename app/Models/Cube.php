<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\Console\Output\ConsoleOutput;

class Cube extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $hidden = array('id', 'created_at', 'updated_at');
    protected $appends = array('cube_images', 'project_cube_images');

    public function pages() {
        return $this->hasMany(Page::class);
    }

    public function generateJson() {
        return $this->with([
            'pages',
            'pages.projects',
            'pages.projects.columns',
        ])->get()->toJson();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(130)
            ->height(130);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image_nx');
        $this->addMediaCollection('image_ny');
        $this->addMediaCollection('image_nz');
        $this->addMediaCollection('image_px');
        $this->addMediaCollection('image_py');
        $this->addMediaCollection('image_pz');

        $this->addMediaCollection('image_project_nx');
        $this->addMediaCollection('image_project_ny');
        $this->addMediaCollection('image_project_nz');
        $this->addMediaCollection('image_project_px');
        $this->addMediaCollection('image_project_py');
        $this->addMediaCollection('image_project_pz');
    }

    public function getCubeImagesAttribute()
    {
        return $this->getMediaFromLabels(['image_nx', 'image_ny', 'image_nz', 'image_px', 'image_py', 'image_pz']);
    }

    public function getProjectCubeImagesAttribute()
    {
        return $this->getMediaFromLabels([
            'image_project_nx', 'image_project_ny', 'image_project_nz',
            'image_project_px', 'image_project_py', 'image_project_pz'
        ]);
    }

    public function getMediaFromLabels($labels) {
        $media = array();
        foreach ($labels as $label) {
            $visual = $this->getFirstMedia($label);
            if ($visual)
                array_push($media, $visual->getFullUrl());
        }
        return $media;
    }
}
