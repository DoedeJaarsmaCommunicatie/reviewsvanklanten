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

    protected function hasRequestKey(Request $request, string $key): bool
    {
        return $request->has($key);
    }
}
