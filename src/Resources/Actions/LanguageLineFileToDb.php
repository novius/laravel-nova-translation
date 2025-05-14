<?php

namespace Novius\LaravelNovaTranslation\Resources\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\MultiSelect;
use Laravel\Nova\Http\Requests\NovaRequest;
use Novius\TranslationLoader\Actions\FileToDb;

class LanguageLineFileToDb extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public function handle(ActionFields $fields, Collection $models)
    {
        $locales = $fields->array('locales');
        if (empty($locales)) {
            return Action::danger(trans('laravel-nova-translation::translation.no_locales'));
        }

        FileToDb::run($models, $locales);

        return Action::message(trans('laravel-nova-translation::translation.file_to_db_success'));
    }

    public function fields(NovaRequest $request): array
    {
        $locales = config('translation-loader.locales', []);
        $options = collect($locales)->mapWithKeys(fn ($locale) => [$locale => $locale]);

        return [
            MultiSelect::make(trans('laravel-nova-translation::translation.languages'), 'locales')
                ->required()
                ->options($options),
        ];
    }
}
