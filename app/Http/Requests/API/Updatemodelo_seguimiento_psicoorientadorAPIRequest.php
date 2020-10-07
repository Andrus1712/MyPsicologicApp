<?php

namespace App\Http\Requests\API;

use App\Models\modelo_seguimiento_psicoorientador;
use InfyOm\Generator\Request\APIRequest;

class Updatemodelo_seguimiento_psicoorientadorAPIRequest extends APIRequest
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
        $rules = modelo_seguimiento_psicoorientador::$rules;
        
        return $rules;
    }
}
