<?php

// Fichier : app/Http/Middleware/ConvertEmptyStringsToNull.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ConvertEmptyStringsToNull
{
    public function handle(Request $request, Closure $next)
    {
        $request->merge($this->convertToNull($request->all()));
        return $next($request);
    }

    private function convertToNull($data)
    {
        return array_map(function ($value) {
            if (is_array($value)) {
                return $this->convertToNull($value);
            }
            return $value === '' ? null : $value;
        }, $data);
    }
}
