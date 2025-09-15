<?php

namespace App\Http\Requests\Career;

use App\Models\Admin;
use App\Models\Career\Job;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class JobCoworkerUpdateRequest extends FormRequest
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
        // Validate the admin_id. (Only root admins can change the admin for a contact.)
        if (empty($this['admin_id'])) {
            $this->merge(['admin_id' => Auth::guard('admin')->user()->id]);
        }
        if (!Auth::guard('admin')->user()->root && ($this['admin_id'] == !Auth::guard('admin')->user()->id)) {
            throw new \Exception('You are not authorized to change the admin for a contact.');
        }

        $adminIds = Auth::guard('admin')->user()->root
            ? Admin::all('id')->pluck('id')->toArray()
            : [Auth::guard('admin')->user()->id];

        return [
            'job_id'          => ['required', 'integer', Rule::in(Job::all('id')->pluck('id')->toArray())],
            'name'            => ['required', 'string', 'max:255'],
            'level'           => ['integer', 'between:1,3'],
            'job_title'       => ['string', 'max:100', 'nullable'],
            'work_phone'      => ['string', 'max:20', 'nullable'],
            'personal_phone'  => ['string', 'max:20', 'nullable'],
            'work_email'      => ['string', 'max:255', 'nullable'],
            'personal_email'  => ['string', 'max:255', 'nullable'],
            'link'            => ['string', 'url:http,https', 'max:255', 'nullable'],
            'link_name'       => ['string', 'max:255', 'nullable'],
            'description'     => ['nullable'],
            'notes'           => ['nullable'],
            'image'           => ['string', 'max:255', 'nullable'],
            'image_credit'    => ['string', 'max:255', 'nullable'],
            'image_source'    => ['string', 'max:255', 'nullable'],
            'thumbnail'       => ['string', 'max:255', 'nullable'],
            'sequence'        => ['integer', 'min:0'],
            'public'          => ['integer', 'between:0,1'],
            'readonly'        => ['integer', 'between:0,1'],
            'root'            => ['integer', 'between:0,1'],
            'disabled'        => ['integer', 'between:0,1'],
            'admin_id'        => ['required', 'integer', Rule::in($adminIds)],
        ];
    }
}
