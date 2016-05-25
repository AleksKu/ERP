<?php

namespace Torg\Base\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Torg\Base\Workspace;

class StoresScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  Builder $builder
     * @param  Model $model
     *
     * @return Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        $context = Workspace::userContext();

        return $builder->whereIn('store_id', $context->stores());
    }
}