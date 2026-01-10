@extends('admin.layouts.default', [
    'title'         => !empty($title) ? $title : 'Reference: ' . $reference->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'References',      'href' => route('admin.career.reference.index') ],
        [ 'name' => $reference->name,  'href' => route('admin.career.reference.show', $reference->id) ],
        [ 'name' => 'Edit' ],
    ],
    'buttons'       => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.career.reference.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
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
                    'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $reference->owner_id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $reference->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'title',
                'value'     => old('title') ?? $reference->title,
                'maxlength' => 100,
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

            @include('admin.components.form-location-horizontal', [
                'street'     => old('street') ?? $reference->street,
                'street2'    => old('street2') ?? $reference->street2,
                'city'       => old('city') ?? $reference->city,
                'state_id'   => old('state_id') ?? $reference->state_id,
                'states'     => \App\Models\System\State::listOptions([], 'id', 'name', true),
                'zip'        => old('zip') ?? $reference->zip,
                'country_id' => old('country_id') ?? $reference->country_id,
                'countries'  => \App\Models\System\Country::listOptions([], 'id', 'name', true),
                'message'    => $message ?? '',
            ])

            @include('admin.components.form-coordinates-horizontal', [
                'latitude'  => old('latitude') ?? $reference->latitude,
                'longitude' => old('longitude') ?? $reference->longitude,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-phone-horizontal', [
                'phone' => old('phone') ?? $reference->phone,
                'label' => old('phone_label') ?? $reference->phone_label,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-phone-horizontal', [
                'phone'   => old('alt_phone') ?? $reference->alt_phone,
                'label'   => old('alt_phone_label') ?? $reference->alt_phone_label,
                'alt'     => true,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-email-horizontal', [
                'email'   => old('email') ?? $reference->email,
                'label'   => old('email_label') ?? $reference->email_label,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-email-horizontal', [
                'email'   => old('alt_email') ?? $reference->alt_email,
                'label'   => old('alt_email_table') ?? $reference->alt_email_label,
                'alt'     => true,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'name'    => 'birthday',
                'value'   => old('birthday') ?? $reference->birthday,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $reference->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $reference->link,
                'name' => old('link_name') ?? $reference->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $reference->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $reference->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'image'   => old('image') ?? $reference->image,
                'credit'  => old('image_credit') ?? $reference->image_credit,
                'source'  => old('image_source') ?? $reference->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'thumbnail',
                'value'   => old('thumbnail') ?? $reference->thumbnail,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'   => old('public') ?? $reference->public,
                'readonly' => old('readonly') ?? $reference->readonly,
                'root'     => old('root') ?? $reference->root,
                'disabled' => old('disabled') ?? $reference->disabled,
                'demo'     => old('demo') ?? $reference->demo,
                'sequence' => old('sequence') ?? $reference->sequence,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.reference.index')
            ])

        </form>

    </div>

@endsection
