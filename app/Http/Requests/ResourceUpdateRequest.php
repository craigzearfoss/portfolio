<?php

namespace App\Http\Requests;

use App\Models\Database;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ResourceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check() && Auth::guard('admin')->user()->root;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'database_id' => ['integer', 'in:' . Database::all()->pluck('id')->toArray()],
            'type'        => ['string', 'max:50', 'filled'],
            'name'        => ['string', 'max:50', 'filled'],
            'plural'      => ['string', 'max:50', 'filled'],
            'front'       => ['integer', 'between:0,1'],
            'user'        => ['integer', 'between:0,1'],
            'admin'       => ['integer', 'between:0,1'],
            'section'     => ['string', 'max:50'], 'filled',
            'icon'        => ['string', 'max:50', 'nullable'],
            'sequence'    => ['integer', 'min:0'],
            'public'      => ['integer', 'between:0,1'],
            'readonly'    => ['integer', 'between:0,1'],
            'root'        => ['integer', 'between:0,1'],
            'disabled'    => ['integer', 'between:0,1'],
            'admin_id'    => ['integer', 'in:' . Auth::guard('admin')->user()->id],
        ];
    }
}
