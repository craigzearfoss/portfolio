<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Portfolio\Academy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CourseStoreRequest extends FormRequest
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

        // Validate the admin_id. (Only root admins can change the admin for a course.)
        if (empty($this['admin_id'])) {
            $this->merge(['admin_id' => Auth::guard('admin')->user()->id]);
        }
        if (!Auth::guard('admin')->root && ($this['admin_id'] == !Auth::guard('admin')->user()->id)) {
            throw new \Exception('You are not authorized to change the admin for a course.');
        }

        return [
            'name'         => ['required', 'string', 'max:255', 'unique:portfolio_db.courses,name'],
            'slug'         => ['required', 'string', 'max:255', 'unique:portfolio_db.courses,slug'],
            'professional' => ['integer', 'between:0,1'],
            'personal'     => ['integer', 'between:0,1'],
            'year'         => ['integer', 'between:0,3000', 'nullable'],
            'completed'    => ['date', 'nullable'],
            'academy_id'   => ['integer', 'in:' . Academy::all()->pluck('id')],
            'school'       => ['string', 'max:255', 'nullable'],
            'instructor'   => ['string', 'max:255', 'nullable'],
            'sponsor'      => ['string', 'max:255', 'nullable'],
            'link'         => ['string', 'max:255', 'nullable'],
            'link_name'    => ['string', 'nullable'],
            'description'  => ['nullable'],
            'image'        => ['string', 'max:255', 'nullable'],
            'image_credit' => ['string', 'max:255', 'nullable'],
            'image_source' => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['string', 'max:255', 'nullable'],
            'sequence'     => ['integer', 'min:0'],
            'public'       => ['integer', 'between:0,1'],
            'readonly'     => ['integer', 'between:0,1'],
            'root'         => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
            'admin_id'     => ['required', 'integer', 'in:' . Auth::guard('admin')->user()->id],
        ];
    }
}
