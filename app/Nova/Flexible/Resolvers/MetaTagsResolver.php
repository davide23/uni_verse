<?php

namespace App\Nova\Flexible\Resolvers;

use Whitecube\NovaFlexibleContent\Value\ResolverInterface;

class MetaTagsResolver implements ResolverInterface
{
    /**
     * get the field's value
     *
     * @param  mixed  $resource
     * @param  string $attribute
     * @param  Whitecube\NovaFlexibleContent\Layouts\Collection $layouts
     * @return Illuminate\Support\Collection
     */
    public function get($resource, $attribute, $layouts)
    {

        $metas = $resource->metas()->get();
        $metas = $metas->map(function($meta, $index) {
            return [
                $meta->key => $meta->value,
            ];
        });
                $metas = $resource->metas()->pluck('value', 'key')->toArray();
        //dd($metas);

        //return $layouts->find('MetaTags')->duplicateAndHydrate($resource->id, ['title' => 'ddd']);
        
        return $layouts->map(function($layout) use ($layouts, $resource, $metas) {
            
            $layout = $layouts->find('MetaTags');

            //if(!$layout) return;

            return $layout->duplicateAndHydrate($resource->id, $metas);
        })->filter();   
        
        /*
        $metas = $resource->metas()->get();
        
        //dd($layouts);

        return $layouts->map(function($layout) use ($resource, $meta) {
            
            //$layout = $layouts->find($meta->name);

            //if(!$layout) return;

            return $layout->duplicateAndHydrate($resource->id, ['title' => 'ddd']);
        })->filter();        
        */
    }

    /**
     * Set the field's value
     *
     * @param  mixed  $model
     * @param  string $attribute
     * @param  Illuminate\Support\Collection $groups
     * @return string
     */
    public function set($model, $attribute, $groups)
    {
        $class = get_class($model);
        
        foreach ($groups as $group) {

            foreach ($group->getAttributes() as $key => $value) {

                $model->setMeta($key, $value);
            }
            
        }
        
        $model->save();
/*
        $class::saved(function ($model) use ($groups) {
            
            foreach ($groups as $group) {
                
                foreach ($group->getAttributes() as $key => $value) {

                    $model->metas()->create( [
                        'key' => $key,
                        'value' => $value,
                    ]);
                }
                //$model->setMeta($key, $value);
            }
            */
            
            //dd($model);
            //$model->save();

            /*
            $metas = $groups->map(function($group, $index) {
                
                $metas = $group->getAttributes();
                
                dd($group);
                return [
                    'key' => $group->name(),
                    'value' => json_encode($group->getAttributes()),
                ];
                
            });

            // This is a quick & dirty example, syncing the models is probably a better idea.
            $model->metas()->delete();
            $model->metas()->createMany($metas);
            */
        //});
    }
}
