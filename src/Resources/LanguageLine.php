<?php

namespace Novius\LaravelNovaTranslation\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Nova\Exceptions\HelperNotSupported;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource as NovaResource;
use Novius\LaravelNovaTranslation\Resources\Actions\LanguageLineDbToFile;
use Novius\LaravelNovaTranslation\Resources\Actions\LanguageLineFileToDb;
use Novius\LaravelNovaTranslation\Resources\Filters\Dirty;
use Novius\TranslationLoader\LanguageLine as LanguageLineModel;

/**
 * @extends NovaResource<LanguageLineModel>
 */
class LanguageLine extends NovaResource
{
    /**
     * The model the resource corresponds to.
     */
    public static string $model = LanguageLineModel::class;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'key',
        'group',
        'text',
        'text_from_files',
    ];

    /**
     * Indicates if the resource should be globally searchable.
     *
     * @var bool
     */
    public static $globallySearchable = false;

    /**
     * Get the displayable label of the resource.
     */
    public static function label(): string
    {
        return trans('laravel-nova-translation::translation.translations');
    }

    /**
     * Get the displayable singular label of the resource.
     */
    public static function singularLabel(): string
    {
        return trans('laravel-nova-translation::translation.translation');
    }

    public function title(): string
    {
        return LanguageLineModel::translationKey($this->resource->namespace, $this->resource->group, $this->resource->key);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @throws HelperNotSupported
     */
    public function fields(Request $request): array
    {
        return [
            Text::make(trans('laravel-nova-translation::translation.namespace'), 'namespace')
                ->filterable()
                ->sortable(),

            Text::make(trans('laravel-nova-translation::translation.group'), 'group')
                ->filterable()
                ->sortable(),

            Text::make(trans('laravel-nova-translation::translation.key'), 'key')
                ->filterable()
                ->sortable(),

            Text::make(trans('laravel-nova-translation::translation.translation'), function () {
                $translations = '';
                foreach ($this->resource->getTranslations() as $locale => $translation) {
                    $translations .= $locale.' : '.Str::limit($translation, 50).'<br>';
                }

                return $translations;
            })->asHtml()->onlyOnIndex(),

            Text::make(trans('laravel-nova-translation::translation.translation_from_file'), function () {
                $translations = '';
                foreach ($this->resource->getTranslations() as $locale => $translation) {
                    $translation = $this->resource->text_from_files[$locale] ?? '';
                    $translations .= $locale.' : '.Str::limit($translation, 50).'<br>';
                }

                return $translations;
            })->asHtml()->onlyOnIndex(),

            Text::make(trans('laravel-nova-translation::translation.dirty'), function () {
                $translations = '';
                foreach ($this->resource->getTranslations() as $locale => $translation) {

                    $translations .= $locale.' : '.(Arr::get($this->resource->dirty_locales, $locale) ? '✔️' : '').'<br>';
                }

                return $translations;
            })->asHtml()->onlyOnIndex(),

            Boolean::make(trans('laravel-nova-translation::translation.orphan'), 'orphan')
                ->filterable()
                ->hideWhenUpdating()
                ->hideWhenCreating(),

            KeyValue::make(trans('laravel-nova-translation::translation.translation'), 'text')
                ->keyLabel(trans('laravel-nova-translation::translation.language'))
                ->valueLabel(trans('laravel-nova-translation::translation.translation'))
                ->actionText(trans('laravel-nova-translation::translation.add_lang'))
                ->disableEditingKeys()
                ->disableDeletingRows(),

            KeyValue::make(trans('laravel-nova-translation::translation.translation_from_file'), 'text_from_files')
                ->keyLabel(trans('laravel-nova-translation::translation.language'))
                ->valueLabel(trans('laravel-nova-translation::translation.translation'))
                ->actionText(trans('laravel-nova-translation::translation.add_lang'))
                ->disableEditingKeys()
                ->disableDeletingRows()
                ->readonly(),
        ];
    }

    public function filters(Request $request): array
    {
        return [
            new Dirty,
        ];
    }

    public function actions(Request $request): array
    {
        return [
            LanguageLineDbToFile::make()
                ->withName(trans('laravel-nova-translation::translation.db_to_file'))
                ->onlyOnIndex(),
            LanguageLineFileToDb::make()
                ->withName(trans('laravel-nova-translation::translation.file_to_db'))
                ->onlyOnIndex(),
        ];
    }
}
