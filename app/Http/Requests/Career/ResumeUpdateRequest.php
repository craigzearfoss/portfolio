<?php

namespace App\Http\Requests\Career;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ResumeUpdateRequest extends FormRequest
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
        // Generate the slug.
        if (!empty($this['name'])) {
            $this->merge([ 'slug' => Str::slug($this['name']) ]);
        }

        // Validate the admin_id. (Only root admins can change the admin for a resume.)
        if (!empty($this['admin_id']) && !Auth::guard('admin')->root
            && ($this['admin_id'] == !Auth::guard('admin')->user()->id)
        ) {
            throw new \Exception('You are not authorized to change the admin for a resume.');
        }

        return [
            'name'         => ['string', 'max:255', 'unique:career_db.resumes,name,'.$this->resume->id, 'filled'],
            'slug'         => ['string', 'max:255', 'unique:career_db.resumes,slug,'.$this->resume->id, 'filled'],
            'date'         => ['date', 'nullable'],
            'year'         => ['integer', 'between:0,3000', 'nullable'],
            'content'      => ['nullable'],
            'link'         => ['string', 'max:255', 'nullable'],
            'link_name'    => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
            'image'        => ['string', 'max:255', 'nullable'],
            'image_credit' => ['string', 'max:255', 'nullable'],
            'image_source' => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['string', 'max:255', 'nullable'],
            'primary'      => ['integer', 'between:0,1'],
            'sequence'     => ['integer', 'min:0'],
            'public'       => ['integer', 'between:0,1'],
            'readonly'     => ['integer', 'between:0,1'],
            'root'         => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
            'admin_id'     => ['integer', 'in:' . Auth::guard('admin')->user()->id],
        ];
    }
}
