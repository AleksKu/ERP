<?php

namespace Torg\Http\Requests\API;

use Torg\Sales\Order;
use Torg\Sales\Repositories\OrderRepository;
use InfyOm\Generator\Request\APIRequest;

class UpdateOrderAPIRequest extends APIRequest
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
        return Order::$rules;
    }
}
