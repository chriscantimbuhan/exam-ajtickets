<?php

namespace App\Burger\Burgers\Actions;

use App\Actions\Action;
use App\Actions\HasFillable;
use App\Actions\HasFillableTrait;
use App\Actions\HasModel;
use App\Actions\HasModelTrait;
use App\Actions\HasRequestTrait;
use App\Actions\RequestAware;
use App\Actions\RequestAwareTrait;
use App\Burger\Models\Burger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreateUpdateBurger extends Action implements HasModel, HasFillable, RequestAware
{
    use HasModelTrait, HasFillableTrait, RequestAwareTrait, HasRequestTrait;

    /**
     * Create new action instance.
     *
     * @param \App\Burger\Models\Burger $burger (optional)
     */
    public function __construct(Burger $burger = null) {
        $this->setModel($burger ?? new Burger);
    }

    /**
     * Execute the action.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->getModel()->save();
        });

        return $this->getModel();
    }

    /**
     * Set values from request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function requestWasSet(Request $request)
    {
        $this->requestWasSetFromHasRequestTrait($request);
    }
}
