<?php

namespace App\Handlers;

use App\Enums\PaymeMethods;
use App\Exceptions\PaymeException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymeRequestHandler
{
    public string $method;
    public array $params;

    /**
     * @throws PaymeException
     */
    public function __construct(Request $request)
    {
        if ($request->method() !== 'POST') {
            throw new PaymeException(PaymeException::INVALID_HTTP_METHOD);
        }

        $data = $request->all();

        if (!isset($data['method']) || !isset($data['params'])) {
            throw new PaymeException(PaymeException::JSON_PARSING_ERROR);
        }

        $this->method = $data['method'];
        $this->params = $data['params'];

        if (Rule::enum(PaymeMethods::class)->passes('', $this->method) === false) {
            throw new PaymeException(PaymeException::METHOD_NOT_FOUND);
        }
    }
}
