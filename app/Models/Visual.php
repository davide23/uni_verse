<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\Console\Output\ConsoleOutput;

class Visual extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $hidden = array('project_id', 'id', 'created_at', 'updated_at');
    protected $appends = array('visual_media');

    public function getVisualMediaAttribute() {
        $media_objects = array();
        $out = new ConsoleOutput();
        $out->writeln('vaffanculop');
        foreach ($this->getMedia('visual_media_objects') as $object) {
            $out->writeln('v111affanculop');
            array_push($media_objects, [
                "path" => $object->getFullUrl(),
                "width" => 200,
                "height" => 100,
                "video" => false,
                "enlargefirst" => true,
                "link" => ""
            ]);
        };
        return $media_objects;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(130)
            ->height(130);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('visual_media_objects');
    }
}
