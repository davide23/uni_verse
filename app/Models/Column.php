<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Column extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $hidden = array('project_id', 'id', 'created_at', 'updated_at');
    protected $appends = array('visual_media');

    public function getVisualMediaAttribute() {
        $media_objects = array();
        foreach ($this->getMedia('visual_media_objects') as $object) {
            array_push($media_objects, [
                "path" => $object->getFullUrl(),
                "width" => 200,
                "height" => 100,
                "video" => false,
                "enlargefirst" => true,
                "link" => "",
                "thumb" => $object->getUrl("thumb"),
            ]);
        };
        foreach ($this->getMedia('visual_media_video') as $object) {
            array_push($media_objects, [
                "path" => $object->getFullUrl(),
                "width" => 200,
                "height" => 100,
                "video" => true,
                "enlargefirst" => true,
                "link" => "",
                "thumb" => $object->getUrl('video_thumb'),
            ]);
        };
        return $media_objects;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('video_thumb')
            ->extractVideoFrameAtSecond(1)
            ->performOnCollections('visual_media_video');

        $this->addMediaConversion('thumb')
            ->performOnCollections('visual_media_objects')
            ->width(130)
            ->height(130);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('visual_media_video');
        $this->addMediaCollection('visual_media_objects');
    }
}
