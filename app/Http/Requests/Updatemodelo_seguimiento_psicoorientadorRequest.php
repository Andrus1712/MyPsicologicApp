<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\modelo_seguimiento_psicoorientador;

class Updatemodelo_seguimiento_psicoorientadorRequest extends FormRequest
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
