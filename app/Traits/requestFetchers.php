<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait requestFetchers
{
    protected function getRequestValueOnKey(Request $request, string $key)
    {
        if (!$this->hasRequestKey($request, $key)) {
            return null;
        }

        return $request->get($key);
    }

    /**
     * @param Request $request
     * @param string|array $key
     *
     * @return bool
     */
    protected function hasRequestKey(Request $request, $key): bool
    {
        foreach ((array) $key as $item) {
            if (!$request->has($item)) {
                return false;
            }
        }
        return true;
    }
}
