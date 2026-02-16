<?php

namespace App\Http\Requests\Career;

use App\Traits\ModelPermissionsTrait;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreCompanyContactsRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->checkDemoMode();

        $this->checkOwner();

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'owner_id'   => ['required', 'integer', 'exists:system_db.admins,id'],
            'company_id' => [
                'required',
                'integer',
                'exists:career_db.companies,id',
                Rule::unique('career_db.company_contact', 'contact_id')->where(function ($query) {
                    return $query->where('company_id', $this->company_id)
                        ->where('owner_id', $this->owner_id);
                }),
            ],
            'contact_id' => ['required', 'integer', 'exists:career_db.contacts,id'],
            'active'     => ['integer', 'between:0,1'],
        ];
    }

    /**
     * Return error messages.
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'company_id.exists'   => 'Company not found.',
            'company_id.unique'   => 'Company contact already exists.',
            'company_id.required' => 'Company not specified.',
            'contact_id.exists'   => 'Contact not found.',
            'contact_id.required' => 'Contact not specified.',
        ];
    }
}
