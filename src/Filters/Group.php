<?php

namespace Novius\LaravelNovaTranslation\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use Novius\TranslationLoader\LanguageLine;

class Group extends Filter
{
    /**
     * Apply the filter to the given query.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where('group', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request)
    {
        return LanguageLine::select('group')
            ->distinct()
            ->orderBy('group', 'ASC')
            ->get()
            ->pluck('group', 'group')
            ->filter()
            ->toArray();
    }
}
