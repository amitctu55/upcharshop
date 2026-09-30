<?php

namespace App\Http\Middleware;

use App\Models\Hospital;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveHospital
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        $subdomain = $this->subdomain($host);

        $hospital = Hospital::where('custom_domain', $host)
            ->when($subdomain !== '', fn ($query) => $query->orWhere('slug', $subdomain))
            ->first();

        if (! $hospital) {
            abort(404, 'Hospital tenant not found.');
        }

        if ($hospital->status !== 'active') {
            return response()->view('site.maintenance', ['hospital' => $hospital], 503);
        }

        app()->instance('current.hospital', $hospital);
        view()->share('hospital', $hospital);

        return $next($request);
    }

    public function subdomain(string $host): string
    {
        // Support ?tenant=slug parameter for environments with DNS limitations
        if (request()->filled('tenant')) {
            $t = trim(request()->query('tenant'));
            if ($t !== '') {
                return $t;
            }
        }

        $parts = explode('.', $host);
        if (end($parts) === 'localhost') {
            $sub = count($parts) >= 2 ? $parts[0] : '';
            return $sub === 'www' ? '' : $sub;
        }
        $sub = count($parts) > 2 ? $parts[0] : $host;
        return $sub === 'www' ? '' : $sub;
    }
}
