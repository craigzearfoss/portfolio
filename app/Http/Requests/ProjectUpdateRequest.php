<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'         => ['string', 'min:1', 'max:255', 'unique:portfolio_db.projects,name,'.$this->project->id],
            'professional' => ['integer', 'between:0,1'],
            'personal'     => ['integer', 'between:0,1'],
            'year'         => ['nullable', 'integer', 'between:0,3000'],
            'repository'   => ['nullable', 'string', 'max:255'],
            'link'         => ['nullable', 'string', 'max:255'],
            'description'  => ['nullable'],
            'hidden'       => ['integer', 'between:0,1'],
            'seq'          => ['integer', 'min:0'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }
}
