@extends('admin.layouts.default', [
    'title' => 'Reference: ' . $reference->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'References',      'href' => route('admin.career.reference.index') ],
        [ 'name' => $reference->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.career.reference.index') ],
    ],
    'errorMessages' => $errors->any() ? ['Fix the indicated errors before saving.'] : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.reference.update', $reference) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.reference.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $reference->id
            ])

            @if(isRootAdmin())
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $reference->owner_id,
                    'required' => true,
                    'list'     => \App\Models\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                    'message'  => $message ?? '',
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $reference->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            <div class="edit-container field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'friend',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('friend') ?? $reference->friend,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'family',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('family') ?? $reference->family,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'coworker',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('coworker') ?? $reference->coworker,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'supervisor',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('supervisor') ?? $reference->supervisor,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'subordinate',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('subordinate') ?? $reference->subordinate,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'professional',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('professional') ?? $reference->professional,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'other',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('other') ?? $reference->other,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-select-horizontal', [
                'name'    => 'company_id',
                'label'   => 'company',
                'value'   => old('company_id') ?? $reference->company_id,
                'list'    => \App\Models\Career\Company::listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'street',
                'value'     => old('street') ?? $reference->street,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'street2',
                'value'     => old('street2') ?? $reference->street2,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'city',
                'value'     => old('city') ?? $reference->city,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'state_id',
                'label'   => 'state',
                'value'   => old('state_id') ?? $reference->state_id,
                'list'    => \App\Models\State::listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'zip',
                'value'     => old('zip') ?? $reference->zip,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'country_id',
                'label'   => 'country',
                'value'   => old('country_id') ?? $reference->country_id,
                'list'    => \App\Models\Country::listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'latitude',
                'value'     => old('latitude') ?? $reference->latitude,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'longitude',
                'value'     => old('longitude') ?? $reference->longitude,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'phone',
                'value'     => old('phone') ?? $reference->phone,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'phone_label',
                'label'     => 'phone label',
                'value'     => old('phone_label') ?? $reference->phone_label,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'alt_phone',
                'label'     => 'alt phone',
                'value'     => old('alt_phone') ?? $reference->alt_phone,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'alt_phone_label',
                'label'     => 'alt phone label',
                'value'     => old('alt_phone_label') ?? $reference->alt_phone_label,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'email',
                'value'     => old('email') ?? $reference->email,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'email_label',
                'label'     => 'email label',
                'value'     => old('email_label') ?? $reference->email_label,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'alt_email',
                'label'     => 'alt email',
                'value'     => old('alt_email') ?? $reference->alt_email,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'alt_email_label',
                'label'     => 'alt email label',
                'value'     => old('alt_email_label') ?? $reference->alt_email_label,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'link',
                'value'     => old('link') ?? $reference->link,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'link_name',
                'label'     => 'link name',
                'value'     => old('link_name') ?? $reference->link_name,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $reference->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'image',
                'value'   => old('image') ?? $reference->image,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'image_credit',
                'label'     => 'image credit',
                'value'     => old('image_credit') ?? $reference->image_credit,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'image_source',
                'label'     => 'image source',
                'value'     => old('image_source') ?? $reference->image_source,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'thumbnail',
                'value'   => old('thumbnail') ?? $reference->thumbnail,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'sequence',
                'value'       => old('sequence') ?? $reference->sequence,
                'min'         => 0,
                'message'     => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'public',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('public') ?? $reference->public,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'readonly',
                                'label'           => 'read-only',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('readonly') ?? $reference->readonly,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'root',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('root') ?? $reference->root,
                                'disabled'        => !isRootAdmin(),
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'disabled',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('disabled') ?? $reference->disabled,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.reference.index')
            ])

        </form>

    </div>

@endsection
