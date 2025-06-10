<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StorCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'maker_id' => ['required','exists:makers,id'], 
            'model_id' => ['required','exists:models,id'], 
            'year' => ['required','integer','min:1970','max:'.date('Y')], 
            'car_type_id'=>['required','exists:car_types,id'],
            'price' => ['required','integer','min:0'],
            'vin' => ['required','string','size:10'],
            'mileage' => ['required','integer','min:0'],
            'fuel_type_id'=>['required','exists:fuel_types,id'],
            'state_id'=>['required','exists:states,id'],
            'city_id'=>['required','exists:cities,id'],
            'address'=>['required','string'],
            'features'=>['array'],
            'features.*'=>['string'],
            'description'=>['required','string'],
            'images' => [$this->isMethod('post') ? 'required' : 'nullable', 'array', 'min:1'],
            'images.*' => [$this->isMethod('post') ? 'required' : 'nullable', 'image', 'max:2048'],


        ];
    }

    public function messages()
    {
        return 
        [
            'required' => 'This field is required'
        ];
    }
    public function attributes()
    {
        return[
            'maker_id' => 'maker',
            'model_id' => 'model',
            'car_type_id' => 'car type',
            'fuel_type_id' => 'fuel type',
            'city_id' => 'region',
        ];
    }

}
