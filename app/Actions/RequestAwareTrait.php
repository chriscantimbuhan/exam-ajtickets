<?php

namespace App\Actions;

use Illuminate\Http\Request;

trait RequestAwareTrait
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Set the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return static
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        $this->requestWasSet($request);

        return $this;
    }

    /**
     * Get the request instance.
     *
     * @return \Illuminate\Http\Request|null
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Method to notify that request is set.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function requestWasSet(Request $request)
    {
    }
}
