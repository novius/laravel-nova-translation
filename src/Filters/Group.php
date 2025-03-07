<?php

namespace Novius\LaravelNovaTranslation\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use Novius\TranslationLoader\LanguageLine;

class Group extends Filter
{
    /**
     * Apply the filter to the given query.
     *
     * @param  Builder  $query
     * @param  mixed  $value
     * @return Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where('group', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @return array
     */
    public function options(Request $request)
    {
        return LanguageLine::query()
            ->select('group')
            ->distinct()
            ->orderBy('group', 'ASC')
            ->get()
            ->pluck('group', 'group')
            ->filter()
            ->toArray();
    }
}
