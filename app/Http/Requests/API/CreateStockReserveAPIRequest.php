<?php

namespace Torg\Http\Requests\API;

use Torg\Erp\Stocks\StockReserve;
use InfyOm\Generator\Request\APIRequest;

class CreateStockReserveAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return StockReserve::$rules;
    }
}
