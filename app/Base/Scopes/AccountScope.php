<?php

namespace Torg\Base\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

/**
 * Class AccountScope
 * @package Torg\Base\Scopes
 */
class AccountScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  Builder $builder
     * @param  Model $model
     *
     *
     * @return $this|void
     */
    public function apply(Builder $builder, Model $model)
    {
        $user = Auth::user();

        return $builder->where('account_id', $user->getAccount()->id);
    }
}