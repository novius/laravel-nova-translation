<?php

namespace Novius\LaravelNovaTranslation\Resources;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Text;

class LanguageLine extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Novius\TranslationLoader\LanguageLine::class;

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
        'key',
        'text',
    ];

    /**
     * Indicates if the resoruce should be globally searchable.
     *
     * @var bool
     */
    public static $globallySearchable = false;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return trans('laravel-nova-translation::translation.translations');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return trans('laravel-nova-translation::translation.translation');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make(trans('laravel-nova-translation::translation.namespace'), 'namespace')->hideFromIndex(),

            Text::make(trans('laravel-nova-translation::translation.namespace'), function () {
                return ($this->namespace === '*') ? '-' : $this->namespace;
            })->asHtml()->onlyOnIndex(),

            Text::make(trans('laravel-nova-translation::translation.group'), 'group'),

            Text::make(trans('laravel-nova-translation::translation.key'), 'key'),

            Text::make(trans('laravel-nova-translation::translation.translation'), function () {
                $translations = '';
                foreach ($this->getTranslations() as $locale => $translation) {
                    $translations .= "$locale : $translation<br>";
                }

                return $translations;
            })->asHtml()->onlyOnIndex(),

            KeyValue::make(trans('laravel-nova-translation::translation.translation'), 'text')
                ->keyLabel(trans('laravel-nova-translation::translation.language'))
                ->valueLabel(trans('laravel-nova-translation::translation.translation'))
                ->actionText(trans('laravel-nova-translation::translation.add_lang')),
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
        return [];
    }
}
