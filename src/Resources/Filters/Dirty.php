<?php

namespace Novius\LaravelNovaTranslation\Resources\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class Dirty extends Filter
{
    /**
     * @param  Builder  $query
     */
    public function apply(NovaRequest $request, $query, mixed $value)
    {
        if ($value === '*') {
            return $query->whereNotNull('dirty_locales');
        }

        return $query->where('dirty_locales', 'LIKE', '%"'.$value.'"%');
    }

    public function options(NovaRequest $request): array
    {
        $locales = config('translation-loader.locales', []);
        $options = collect($locales)->mapWithKeys(fn ($locale) => [$locale => $locale]);

        if (count($locales) > 1) {
            $options->prepend('*',
                trans('laravel-nova-translation::translation.dirty_filter_one'));
        }

        return $options->toArray();
    }
}
