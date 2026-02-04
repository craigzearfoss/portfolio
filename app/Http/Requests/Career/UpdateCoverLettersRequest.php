<?php

namespace App\Http\Requests\Career;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCoverLettersRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * @throws \Exception
     */
    public function rules(): array
    {
        return [
            'owner_id'          => ['filled', 'integer', 'exists:system_db.admins,id'],
            'application_id'    => ['filled', 'integer', 'exists:career_db.applications,id'],
            'name'              => [
                'filled',
                'string',
                'max:255',
                Rule::unique('career_db.cover_letters', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name)
                        ->where('date', $this->date)
                        ->where('id', '!=', $this->cover_letters->id);
                })
            ],
            'slug'              => [
                'filled',
                'string',
                'max:255',
                Rule::unique('career_db.cover_letters', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('slug', $this->slug)
                        ->where('date', $this->date)
                        ->where('id', '!=', $this->cover_letters->id);
                })
            ],
            'date'              => ['date', 'nullable'],
            'filepath'          => ['string', 'max:500', 'nullable'],
            'content'           => ['nullable'],
            'notes'             => ['nullable'],
            'link'              => ['string', 'max:500', 'nullable'],
            'link_name'         => ['string', 'max:255', 'nullable'],
            'description'       => ['nullable'],
            'disclaimer'        => ['string', 'max:500', 'nullable'],
            'image'             => ['string', 'max:500', 'nullable'],
            'image_credit'      => ['string', 'max:255', 'nullable'],
            'image_source'      => ['string', 'max:255', 'nullable'],
            'thumbnail'         => ['string', 'max:500', 'nullable'],
            'public'            => ['integer', 'between:0,1'],
            'readonly'          => ['integer', 'between:0,1'],
            'root'              => ['integer', 'between:0,1'],
            'disabled'          => ['integer', 'between:0,1'],
            'demo'              => ['integer', 'between:0,1'],
            'sequence'          => ['integer', 'min:0', 'nullable'],
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
            'owner_id.filled'       => 'Please select an owner for the cover letter.',
            'owner_id.exists'       => 'The specified owner does not exist.',
            'application_id.filled' => 'Please select an application for the cover letter.',
            'application_id.exists' => 'The specified application does not exist.',
            'name.unique'           => 'There is already a cover letter with the same name for this date.',
            'slug.unique'           => 'There is already a cover letter with the same slug for this date.'
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
            $slug = !empty($this['date'])
                ? $this['date'] . '-' . $this['name']
                : $this['name'];

            $this->merge([
                'slug' => uniqueSlug($slug),
                'career_db.cover_letters',
                $this->owner_id
            ]);
        }
    }
}
