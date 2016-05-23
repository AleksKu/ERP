<?php

namespace Torg\Http\Requests\API;

use InfyOm\{
    Generator\Request\APIRequest
};
use Torg\Stocks\StockReserve;

class UpdateStockReserveAPIRequest extends APIRequest
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
