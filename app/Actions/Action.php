<?php

namespace App\Actions;

use LogicException;

abstract class Action
{
    /**
     * Called before the job runs.
     * 
     * @return void
     */
    protected function before()
    {
    }

    /**
     * Run/perform the action.
     *
     * @return mixed
     */
    public function run()
    {
        $this->before();

        if ($this instanceof HasValidation) {
            $this->validate();
        }

        if (! method_exists($this, 'handle')) {
            throw new LogicException(static::class.' must implement "handle" method');
        }

        // Try to resolve parameters from the container.
        $result = app()->call([$this, 'handle']);

        $this->after($result);

        return $result;
    }

    /**
     * Alias of run
     * 
     * @return mixed
     */
    public function execute()
    {
        return $this->run();
    }

    /**
     * Called after job ran.
     * 
     * @param mixed $result
     * @return void
     */
    protected function after($result)
    {
    }

    /**
     * Create new instance.
     *
     * @return static
     */
    public static function create()
    {
        return new static(...func_get_args());
    }

    /**
     * Create a new action instance then execute.
     *
     * @return mixed
     */
    public static function createAndRun()
    {
        return static::create(...func_get_args())->run();
    }

    /**
     * Invoke the object as function.
     * 
     * @return mixed
     */
    public function __invoke()
    {
        return $this->run();
    }
}
