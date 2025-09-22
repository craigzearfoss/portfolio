<?php

namespace App\Http\Requests\Career;

use App\Models\Admin;
use App\Models\Career\Application;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CommunicationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isRootAdmin()
            || (isAdmin() && ($this->communication->id == Auth::guard('admin')->user()->id));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * @throws \Exception
     */
    public function rules(): array
    {
        // Validate the admin_id. (Only root admins can change the admin for a communication.)
        if (!empty($this['admin_id']) && !Auth::guard('admin')->user()->root
            && ($this['admin_id'] == !Auth::guard('admin')->user()->id)
        ) {
            throw new \Exception('You are not authorized to change the admin for a communication.');
        }

        $adminIds = Auth::guard('admin')->user()->root
            ? Admin::all('id')->pluck('id')->toArray()
            : [Auth::guard('admin')->user()->id];

        return [
            'application_id' => ['integer', Rule::in(Application::all('id')->pluck('id')->toArray())],
            'subject'        => ['string', 'max:255', 'filled'],
            'date'           => ['required', 'date_format:Y-m-d'],
            'time'           => ['required', 'date_format:H:i:s'],
            'body'           => ['filled'],
            'sequence'       => ['integer', 'min:0'],
            'public'         => ['integer', 'between:0,1'],
            'readonly'       => ['integer', 'between:0,1'],
            'root'           => ['integer', 'between:0,1'],
            'disabled'       => ['integer', 'between:0,1'],
            'admin_id'       => ['integer', Rule::in($adminIds)],
        ];
    }
}
