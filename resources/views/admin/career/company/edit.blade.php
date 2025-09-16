@extends('admin.layouts.default', [
    'title' => $company->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Companies',       'url' => route('admin.career.company.index') ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => Request::header('referer') ?? route('admin.career.company.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card form-container p-4">

        <form action="{{ route('admin.career.company.update', $company) }}" method="POST">
            @csrf
            @method('PUT')

            @if(Auth::guard('admin')->user()->root)
                @include('admin.components.form-select-horizontal', [
                    'name'    => 'admin_id',
                    'label'   => 'admin',
                    'value'   => old('admin_id') ?? $company->admin_id,
                    'list'    => \App\Models\Admin::listOptions(),
                    'message' => $message ?? '',
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $company->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'industry_id',
                'label'   => 'industry',
                'value'   => old('industry_id') ?? $company->industry_id,
                'list'    => \App\Models\Career\Industry::listOptions(false),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'street',
                'value'     => old('street') ?? $company->street,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'street2',
                'value'     => old('street2') ?? $company->street2,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'city',
                'value'     => old('city') ?? $company->city,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'state',
                'value'   => old('state') ?? $company->state,
                'list'    => \App\Models\State::listOptions(true, true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'zip',
                'value'     => old('zip') ?? $company->zip,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'country',
                'value'   => old('country') ?? $company->country,
                'list'    => \App\Models\Country::listOptions(true, true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'phone',
                'value'     => old('phone') ?? $company->phone,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'phone_label',
                'label'     => 'phone label',
                'value'     => old('phone_label') ?? $company->phone_label,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'alt_phone',
                'label'     => 'alt phone',
                'value'     => old('alt_phone') ?? $company->alt_phone,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'alt_phone_label',
                'label'     => 'alt phone label',
                'value'     => old('alt_phone_label') ?? $company->alt_phone_label,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'email',
                'value'     => old('email') ?? $company->email,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'email_label',
                'label'     => 'email label',
                'value'     => old('email_label') ?? $company->email_label,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'alt_email',
                'label'     => 'alt email',
                'value'     => old('alt_email') ?? $company->alt_email,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'alt_email_label',
                'label'     => 'alt email label',
                'value'     => old('alt_email_label') ?? $company->alt_email_label,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'link',
                'value'     => old('link') ?? $company->link,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'link_name',
                'label'     => 'link name',
                'value'     => old('link_name') ?? $company->link_name,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $company->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'image',
                'value'   => old('image') ?? $company->image,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'image_credit',
                'label'     => 'image credit',
                'value'     => old('image_credit') ?? $company->image_credit,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'image_source',
                'label'     => 'image source',
                'value'     => old('image_source') ?? $company->image_source,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'thumbnail',
                'value'   => old('thumbnail') ?? $company->thumbnail,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'sequence',
                'value'       => old('sequence') ?? $company->sequence,
                'min'         => 0,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'public',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('public') ?? $company->public,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'readonly',
                'label'           => 'read-only',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('readonly') ?? $company->readonly,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'root',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('root') ?? $company->root,
                'disabled'        => !Auth::guard('admin')->user()->root,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'disabled',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('disabled') ?? $company->disabled,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => Request::header('referer') ?? route('admin.career.company.index')
            ])

        </form>

    </div>

@endsection
