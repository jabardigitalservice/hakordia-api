<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HealthCheckController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        Log::info('HEALTHCHECK');

        // try to connect DB health check
        $dbConnection = config('database.default');

        if (!empty($dbConnection)) {
            DB::connection()->getPdo();
        }

        return [
            'app'    => config('app.name'),
            'server' => gethostname(),
        ];
    }
}
