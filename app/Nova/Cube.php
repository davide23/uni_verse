<?php

namespace App\Nova;

use App\Nova\Actions\GenerateJsonRepresentation;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Cube extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Cube::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            HasMany::make('Pages'),
            Text::make('Title'),

            Images::make('NX', 'image_nx')
                ->fullSize()
                ->setFileName(function($originalFilename, $extension, $model){
                    return 'cube_nx.jpg';
                }),

            Images::make('NY', 'image_ny')
                ->fullSize()
                ->setFileName(function($originalFilename, $extension, $model){
                    return 'cube_ny.jpg';
                }),

            Images::make('NZ', 'image_nz')
                ->fullSize()
                ->setFileName(function($originalFilename, $extension, $model){
                    return 'cube_nz.jpg';
                }),

            Images::make('PX', 'image_px')
                ->fullSize()
                ->setFileName(function($originalFilename, $extension, $model){
                    return 'cube_px.jpg';
                }),

            Images::make('PY', 'image_py')
                ->fullSize()
                ->setFileName(function($originalFilename, $extension, $model){
                    return 'cube_py.jpg';
                }),

            Images::make('PZ', 'image_pz')
                ->fullSize()
                ->setFileName(function($originalFilename, $extension, $model){
                    return 'cube_pz.jpg';
                }),

            Images::make('Project - NX', 'image_project_nx')
                ->fullSize()
                ->setFileName(function($originalFilename, $extension, $model){
                    return 'image_project_nx.jpg';
                }),

            Images::make('Project - NY', 'image_project_ny')
                ->fullSize()
                ->setFileName(function($originalFilename, $extension, $model){
                    return 'image_project_ny.jpg';
                }),

            Images::make('Project - NZ', 'image_project_nz')
                ->fullSize()
                ->setFileName(function($originalFilename, $extension, $model){
                    return 'image_project_nz.jpg';
                }),

            Images::make('Project - PX', 'image_project_px')
                ->fullSize()
                ->setFileName(function($originalFilename, $extension, $model){
                    return 'image_project_px.jpg';
                }),

            Images::make('Project - PY', 'image_project_py')
                ->fullSize()
                ->setFileName(function($originalFilename, $extension, $model){
                    return 'image_project_py.jpg';
                }),

            Images::make('Project - PZ', 'image_project_pz')
                ->fullSize()
                ->setFileName(function($originalFilename, $extension, $model){
                    return 'image_project_pz.jpg';
                }),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new GenerateJsonRepresentation),
        ];
    }
}
