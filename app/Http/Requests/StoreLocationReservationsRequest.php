<?php

namespace App\Http\Requests;

use App\Rules\DateBetween;
use App\Rules\TimeBetween;
use Illuminate\Foundation\Http\FormRequest;

class StoreLocationReservationsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'res_date' => ['required', 'date', new DateBetween, new TimeBetween],
             'checkout_date' => ['required', 'date', new DateBetween, new TimeBetween],
            'tel_number' => ['required'],
            'location_id' => ['required'],
        ];
    }
}
