<?php

namespace App\Http\Requests\Career;

use App\Models\Admin;
use App\Models\Career\Application;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CoverLetterStoreRequest extends FormRequest
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
        // Validate the admin_id. (Only root admins can change the admin for a cover letter.)
        if (empty($this['admin_id'])) {
            $this->merge(['admin_id' => Auth::guard('admin')->user()->id]);
        }
        if (!Auth::guard('admin')->user()->root && ($this['admin_id'] == !Auth::guard('admin')->user()->id)) {
            throw new \Exception('You are not authorized to change the admin for a cover letter.');
        }

        $adminIds = Auth::guard('admin')->user()->root
            ? Admin::all('id')->pluck('id')->toArray()
            : [Auth::guard('admin')->user()->id];

        return [
            'application_id'   => ['integer', Rule::in(Application::all('id')->pluck('id')->toArray())],
            'date'             => ['date', 'nullable'],
            'content'          => ['nullable'],
            'cover_letter_url' => ['string', 'url:http,https', 'max:255', 'nullable'],
            'link'             => ['string', 'url:http,https', 'max:255', 'nullable'],
            'link_name'        => ['string', 'max:255', 'nullable'],
            'description'      => ['nullable'],
            'image'            => ['string', 'max:255', 'nullable'],
            'image_credit'     => ['string', 'max:255', 'nullable'],
            'image_source'     => ['string', 'max:255', 'nullable'],
            'thumbnail'        => ['string', 'max:255', 'nullable'],
            'sequence'         => ['integer', 'min:0'],
            'public'           => ['integer', 'between:0,1'],
            'readonly'         => ['integer', 'between:0,1'],
            'root'             => ['integer', 'between:0,1'],
            'disabled'         => ['integer', 'between:0,1'],
            'admin_id'         => ['required', 'integer', Rule::in($adminIds)],
        ];
    }
}
