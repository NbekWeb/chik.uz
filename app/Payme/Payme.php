<?php

namespace App\Payme;

use App\Handlers\PaymeRequestHandler;
use App\Services\PaymeService;
use Illuminate\Http\Request;

class Payme
{
    /**
     * @throws PaymeException
     */
    public function handle(Request $request)
    {
        $handler = new PaymeRequestHandler($request);
        return (new PaymeService($handler->params))->{$handler->method}();
    }
}
