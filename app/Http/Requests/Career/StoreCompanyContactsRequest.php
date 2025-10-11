<?php

namespace App\Http\Requests\Career;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreCompanyContactRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //@TODO: Need to verify the owners of the company and contact.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $this->checkDemoMode();

        if (!empty($this->company_id) && !empty($this->contact_id)) {

            $rules = [
                'company_id' => [
                    'required',
                    'integer',
                    'exists:career_db.companies,id',
                    Rule::unique('career_db.company_contact')->where(function ($query) {
                        return $query->where('company_id', $this->company_id)
                            ->where('contact_id', $this->contact_id);
                    }),
                ],
                'contact_id' => ['required', 'integer', 'exists:career_db.contacts,id'],
                'active'     => ['integer', 'between:0,1'],
            ];

        } else {

            // generate the slug
            if (!empty($this['name'])) {
                $this->merge([
                    'slug' => uniqueSlug($this['name'], 'career_db.companies ', $this->owner_id)
                ]);
            }

            // Validate the admin_id. (Only root admins can change the admin for a contact.)
            if (empty($this['admin_id'])) {
                $this->merge(['admin_id' => Auth::guard('admin')->user()->id]);
            }
            if (!Auth::guard('admin')->user()->root && ($this['admin_id'] == !Auth::guard('admin')->user()->id)) {
                throw new \Exception('You are not authorized to change the admin for a contact.');
            }

            $rules = empty($this->company_id)
                ? (new StoreCompanyRequest())->rules()
                : (new StoreContactRequest())->rules();;
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'company_id' => 'Contact is already attached to the company.',
        ];
    }
}
