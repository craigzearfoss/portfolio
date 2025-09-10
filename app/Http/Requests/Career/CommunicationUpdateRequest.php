<?php

namespace App\Http\Requests\Career;

use App\Models\Career\Application;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommunicationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Validate the admin_id. (Only root admins can change the admin for a communication.)
        if (!empty($this['admin_id']) && !Auth::guard('admin')->root
            && ($this['admin_id'] == !Auth::guard('admin')->user()->id)
        ) {
            throw new \Exception('You are not authorized to change the admin for a communication.');
        }

        return [
            'application_id' => ['integer', 'in:' . implode(',', Application::all('id')->pluck('id')->toArray())],
            'subject'        => ['string', 'max:255', 'filled'],
            'date'           => ['required', 'date_format:Y-m-d'],
            'time'           => ['required', 'date_format:H:i:s'],
            'body'           => ['filled'],
            'sequence'       => ['integer', 'min:0'],
            'public'         => ['integer', 'between:0,1'],
            'readonly'       => ['integer', 'between:0,1'],
            'root'           => ['integer', 'between:0,1'],
            'disabled'       => ['integer', 'between:0,1'],
            'admin_id'       => ['integer', 'in:' . Auth::guard('admin')->user()->id],
        ];
    }
}
