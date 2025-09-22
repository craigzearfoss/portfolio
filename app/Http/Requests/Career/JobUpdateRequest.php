<?php

namespace App\Http\Requests\Career;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class JobUpdateRequest extends FormRequest
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
     * @throws \Exception
     */
    public function rules(): array
    {
        // Generate the slug.
        if (!empty($this['name'])) {
            $this->merge([ 'slug' => Str::slug($this['name']) ]);
        }

        // Validate the admin_id. (Only root admins can change the admin for a job.)
        if (!empty($this['admin_id']) && !Auth::guard('admin')->user()->root
            && ($this['admin_id'] == !Auth::guard('admin')->user()->id)
        ) {
            throw new \Exception('You are not authorized to change the admin for a job.');
        }

        $adminIds = Auth::guard('admin')->user()->root
            ? Admin::all('id')->pluck('id')->toArray()
            : [Auth::guard('admin')->user()->id];

        return [
            'name'         => ['string', 'max:255', 'unique:career_db.jobs,name,'.$this->job->id, 'filled'],
            'slug'         => ['string', 'max:255', 'unique:career_db.jobs,slug,'.$this->job->id, 'filled'],
            'featured'     => ['integer', 'between:0,1'],
            'professional' => ['integer', 'between:0,1'],
            'personal'     => ['integer', 'between:0,1'],
            'role'         => ['string', 'max:255',],
            'start_month'  => ['integer', 'between:1,12', 'nullable' ],
            'start_year'   => ['integer', 'min:1980', 'max:'.date("Y"), 'nullable'],
            'end_month'    => ['integer', 'between:1,12', 'nullable' ],
            'end_year'     => ['integer', 'min:1980', 'max:'.date("Y"), 'nullable'],
            'summary'      => ['string', 'max:255', 'nullable'],
            'notes'        => ['nullable'],
            'street'       => ['string', 'max:255', 'nullable'],
            'street2'      => ['string', 'max:255', 'nullable'],
            'city'         => ['string', 'max:100', 'nullable'],
            'state'        => ['string', 'max:20', 'nullable'],
            'zip'          => ['string', 'max:20', 'nullable'],
            'country'      => ['string', 'max:100', 'nullable'],
            'latitude'     => ['numeric:strict', 'nullable'],
            'longitude'    => ['numeric:strict', 'nullable'],
            'link'         => ['string', 'url:http,https', 'max:255', 'nullable'],
            'link_name'    => ['string', 'max:255', 'nullable'],
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
            'admin_id'     => ['integer', Rule::in($adminIds)],
        ];
    }
}
