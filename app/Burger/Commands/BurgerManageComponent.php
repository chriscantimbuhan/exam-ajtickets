<?php

namespace App\Burger\Commands;

use App\Burger\Components\Actions\CreateUpdateComponent;
use App\Burger\Models\BurgerComponent;
use App\Burger\Requests\BurgerComponentRequest;
use App\Support\CommandValidatorTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class BurgerManageComponent extends Command
{
    use CommandValidatorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'burger:manage-component';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage Burger components';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->begin();
    }

    protected function begin()
    {
        $this->info('Manage Burger Components');

        if ($this->choice('Select one option:', $this->handleChoices()) == 'Create') {
            $this->store(new BurgerComponentRequest($this->fields()));
        } else {
            $this->displayList();

            $id = $this->ask('ID:');

            $burgerComponent = (new BurgerComponent)->whereKey($id)->first();

            $this->update(new BurgerComponentRequest($this->fields($burgerComponent)), $burgerComponent);
        }
    }

    protected function handleChoices()
    {
        $choices = ['1' => 'Create'];

        if (BurgerComponent::count()) {
            $choices['2'] = 'Update';
        }

        return $choices;      
    }

    protected function displayList()
    {
        return $this->table(
            Schema::getColumnListing((new BurgerComponent)->getTable()),
            (new BurgerComponent)->get()->toArray());
    }

    /**
     * Initiate fillable fields
     *
     * @param \App\Burger\Models\BurgerComponent|null $burgerComponent
     * @return array
     */
    protected function fields(BurgerComponent $burgerComponent = null)
    {
        return [
            'name' => $this->ask('Component name:'),
            'description' => $this->ask('Description:'),
            'countable' => $this->ask('Countable (1 = true,0 = false):')
        ];
    }

    /**
     * Store a burger component
     *
     * @param \App\Burger\Requests\BurgerComponentRequest $request
     * @return string
     */
    protected function store(BurgerComponentRequest $request)
    {
        $validator = $this->applyValidator($request);

        if ($validator) {
            $this->error($validator);

            $this->store(new BurgerComponentRequest($this->fields()));
        }

        $model = (new CreateUpdateComponent)->setRequest($request)->execute();

        $name = Str::ucfirst($model->name);

        $this->info("Burger Component {$name} created successfully");
    }

    /**
     * Update a burger component
     *
     * @param \App\Burger\Requests\BurgerComponentRequest $request
     * @param \App\Burger\Models\BurgerComponent $burgerComponent
     * @return string
     */
    protected function update(BurgerComponentRequest $request, BurgerComponent $burgerComponent)
    {
        $validator = $this->applyValidator($request);

        if ($validator) {
            $this->error($validator);

            $this->store(new BurgerComponentRequest($this->fields()));
        }

        $model = (new CreateUpdateComponent($burgerComponent))->setRequest($request)->execute();

        $name = Str::ucfirst($model->name);

        $this->info("Burger Component {$name} updated successfully");
    }
}
