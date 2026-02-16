<?php

namespace App\Http\Requests\Career;

use App\Traits\ModelPermissionsTrait;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreResumesRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'owner_id'     => ['required', 'integer', 'exists:system_db.admins,id'],
            'name'         => [
                'required',
                'string',
                'max:255',
                Rule::unique('career_db.resumes', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('date', $this->date)
                        ->where('name', $this->name);
                })
            ],
            'slug'         => [
                'required',
                'string',
                'max:255',
                Rule::unique('career_db.resumes', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('date', $this->date)
                        ->where('slug', $this->slug);
                })
            ],
            'date'  => ['date', 'nullable'],
            'primary'      => ['integer', 'between:0,1'],
            'year'         => ['integer', 'between:0,3000', 'nullable'],
            'doc_filepath' => ['string', 'max:500', 'nullable'],
            'pdf_filepath' => ['string', 'max:500', 'nullable'],
            'content'      => ['nullable'],
            'file_type'    => ['string', 'max:10', 'nullable'],
            'notes'        => ['nullable'],
            'link'         => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'    => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
            'disclaimer'   => ['string', 'max:500', 'nullable'],
            'image'        => ['string', 'max:500', 'nullable'],
            'image_credit' => ['string', 'max:255', 'nullable'],
            'image_source' => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['string', 'max:500', 'nullable'],
            'public'       => ['integer', 'between:0,1'],
            'readonly'     => ['integer', 'between:0,1'],
            'root'         => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
            'demo'         => ['integer', 'between:0,1'],
            'sequence'     => ['integer', 'min:0', 'nullable'],
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
            'owner_id.required' => 'Please select an owner for the resume.',
            'owner_id.exists'   => 'The specified owner does not exist.',
            'name.unique'       => 'There is already a resume with the same name for this date.',
            'slug.unique'       => 'There is already a resume with the same slug for this date.'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation()
    {
        // generate the slug
        if (!empty($this['name'])) {
            $slug = !empty($this['date']) . !empty($this['name']) ? '-' . $this['name'] : '';
            $this->merge([
                'slug' => uniqueSlug($slug),
                'career_db.resumes',
                $this->owner_id
            ]);
        }
    }
}
