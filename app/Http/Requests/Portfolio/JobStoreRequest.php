<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Country;
use App\Models\Owner;
use App\Models\State;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class JobStoreRequest extends FormRequest
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
     * *
     * * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * @throws \Exception
     */
    public function rules(): array
    {
        // Generate the slug.
        if (!empty($this['name'])) {
            $this->merge([ 'slug' => Str::slug($this['name']) ]);
        }

        // Validate the admin_id. (Only root admins can change the admin for a job.)
        if (empty($this['admin_id'])) {
            $this->merge(['admin_id' => Auth::guard('admin')->user()->id]);
        }
        if (!Auth::guard('admin')->user()->root && ($this['admin_id'] == !Auth::guard('admin')->user()->id)) {
            throw new \Exception('You are not authorized to change the admin for a job.');
        }

        $ownerIds = isRootAdmin()
            ? Owner::all('id')->pluck('id')->toArray()
            : [ Auth::guard('admin')->user()->id ];

        return [
            'owner_id'     => ['integer', 'required', Rule::in($ownerIds)],
            'company'      => ['string', 'max:255', 'required', 'unique:career_db.jobs,name'],
            'slug'         => [
                'string',
                'required',
                'max:255',
                Rule::unique('portfolio_db.jobs')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('slug', $this->slug);
                })
            ],
            'featured'     => ['integer', 'between:0,1'],
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
            'state_id'     => ['integer', Rule::in(State::all('id')->pluck('id')->toArray()), 'nullable'],
            'zip'          => ['string', 'max:20', 'nullable'],
            'country_id'   => ['integer', Rule::in(Country::all('id')->pluck('id')->toArray()), 'nullable'],
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
        ];
    }
}
