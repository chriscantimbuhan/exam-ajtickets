<?php

namespace App\Burger\Commands;

use App\Burger\Burgers\Actions\CreateUpdateBurger;
use App\Burger\Models\BurgerComponent;
use App\Burger\Requests\BurgerRequest;
use App\Support\CommandValidatorTrait;
use Illuminate\Console\Command;

class BurgerBuild extends Command
{
    use CommandValidatorTrait;

    /**
     * @var string
     */
    protected $customerName;

    /**
     * @var array
     */
    protected $burgerComponents;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'burger:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build a burger';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->customer();

        $this->build();
    }

    /**
     * Register customer
     *
     * @return string
     */
    protected function customer()
    {
        $customerName = $this->ask('What is your name?');

        $request = new BurgerRequest([
            'customer_name' => $customerName,
        ]);

        $validator = $this->fieldValidation($request, 'customer_name');

        if ($validator) {
            $this->error($validator);

            $this->customer();
        }

        $this->customerName = $customerName;

        $this->line("Welcome {$this->customerName}, Build your own Burger");
    }

    /**
     * Build a burger
     *
     * @return mixed
     */
    protected function build()
    {
        $this->listBurgerComponents();
        $this->askComponents();
    }

    /**
     * Get available burger components
     *
     * @return mixed
     */
    protected function listBurgerComponents()
    {
        $this->line('');
        $this->info('Available Burger Components:');

        $this->table(['id', 'name'], (new BurgerComponent)->orderBy('id', 'ASC')->get(['id', 'name'])->toArray());

        $this->comment('Select the component id separated by commas, example: 1,2,3...');
    }

    /**
     * Choose components of the burger
     *
     * @return array
     */
    protected function askComponents()
    {
        $this->burgerComponents = '';

        $components = $this->ask('Choose your burger components');

        $request = new BurgerRequest([
            'components' => $components,
        ]);

        $validator = $this->fieldValidation($request, 'components');

        if ($validator) {
            $this->error($validator);

            $this->askComponents();
        }

        if ($invalidIds = $this->checkIfComponentExists($components)) {
            $this->error(
                'Component id/s ' . implode(',', $invalidIds) . ' does not exists.'
            );

            $this->askComponents();
        }

        $this->setBurgerComponents($components);

        $this->confirmOrder($this->getBurgerComponents());
    }

    /**
     * Check if component record exists
     *
     * @param string $components
     * @return mixed
     */
    protected function checkIfComponentExists($components)
    {
        $components = explode(',', $components);
        $invalidComponents = [];

        foreach ($components as $component) {
            if (! (new BurgerComponent)->whereKey($component)->first()) {
                $invalidComponents[] = $component;
            }
        }

        if (count($invalidComponents) > 0) {
            return $invalidComponents;
        }
    }

    /**
     * Confirm order
     *
     * @param string $components
     * @return mixed
     */
    protected function confirmOrder($components)
    {
        $this->showSelectedComponents($components);

        if ($this->confirm('Are you sure about your burger?')) {

            $this->store();

            $this->info('Burger Completed');

            if ($this->confirm('Do you  want to have another one?')) {
                $this->build();
            } else {
                $this->info('Thank you. Come again.');
                exit;
            }
        } else {
            $this->build();
        }
    }

    /**
     * Get count of each component
     *
     * @param \Illuminate\Database\Eloquent\Collection $components
     * @return array
     */
    protected function componentPieces($components)
    {
        $counter = [];

        foreach ($components as $component) {
            if ($component->countable) {
                $counter[$component->getKey()] = $this->ask("How many $component->name do you like?");
            }
        }

        return $counter;
    }

    /**
     * Get components for confirmation
     *
     * @param array
     * @return mixed
     */
    protected function showSelectedComponents($components)
    {
        $components = (new BurgerComponent)->whereKey(explode(',', $components))->get();

        $componentPieces = $this->componentPieces($components);

        $burgerData = [];
        
        $this->info('Your burger will have:');

        foreach ($components as $component) {
            if (array_key_exists($component->getKey(), $componentPieces)) {
                $this->line($component->name . ':' . $componentPieces[$component->getKey()]);
                
                $burgerData[] = [$component->getKey() => $componentPieces[$component->getKey()]];
            } else {
                $this->line($component->name);
                $burgerData[] = [$component->getKey() => 0];
            }
        }

        $this->components = $burgerData;
    }

    /**
     * Store completed burger
     *
     * @return void
     */
    protected function store()
    {
        $request = new BurgerRequest([
            'customer_name' => $this->customerName,
            'components' => json_encode($this->components)
        ]);

        $validator = $this->applyValidator($request);

        if ($validator) {
            $this->error($validator);
        }

        (new CreateUpdateBurger)->setRequest($request)->execute();
    }

    // Getter for 'burgerComponents' property
    public function getBurgerComponents() {
        return $this->burgerComponents;
    }

    // Setter for 'burgerComponents' property
    public function setBurgerComponents($burgerComponents) {
        $this->burgerComponents = $burgerComponents;
    }
}
