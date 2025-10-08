<?php

namespace App\Http\Requests\Career;

use App\Models\Career\Application;
use App\Models\Owner;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CommunicationUpdateRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isRootAdmin() || ($this->communication->owner_id == Auth::guard('admin')->user()->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * @throws \Exception
     */
    public function rules(): array
    {
        $this->checkDemoMode();

        // Validate the admin_id. (Only root admins can change the admin for a communication.)
        if (!empty($this['admin_id']) && !Auth::guard('admin')->user()->root
            && ($this['admin_id'] == !Auth::guard('admin')->user()->id)
        ) {
            throw new \Exception('You are not authorized to change the admin for a communication.');
        }

        return [
            'owner_id'       => ['required', 'integer', 'filled', 'exists:core_db.admins,id'],
            'application_id' => ['integer', 'filled', 'exists:career_db.applications,id'],
            'subject'        => ['string', 'filled', 'max:255'],
            'date'           => ['date_format:Y-m-d'],
            'time'           => ['date_format:H:i:s'],
            'body'           => ['nullable'],
            'sequence'       => ['integer', 'min:0'],
            'public'         => ['integer', 'between:0,1'],
            'readonly'       => ['integer', 'between:0,1'],
            'root'           => ['integer', 'between:0,1'],
            'disabled'       => ['integer', 'between:0,1'],
        ];
    }
}
