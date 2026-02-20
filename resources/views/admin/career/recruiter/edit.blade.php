@php
    use App\Models\System\Country;
    use App\Models\System\State;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Recruiters',      'href' => route('admin.career.recruiter.index') ],
        [ 'name' => $recruiter->name,  'href' => route('admin.career.recruiter.show', $recruiter) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $buttons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.career.recruiter.index')])->render(),
    ];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? (!empty($title) ? $title :'Recruiter: ' . $recruiter->name),
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.recruiter.update', array_merge([$recruiter], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.recruiter.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $recruiter->id
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $recruiter->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'postings_url',
                'label'     => 'postings url',
                'value'     => old('postings_url') ?? $recruiter->postings_url,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field" style="flex-grow: 0;">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'local',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('local') ?? $recruiter->local,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'regional',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('regional') ?? $recruiter->regional,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'national',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('national') ?? $recruiter->national,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'international',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('international') ?? $recruiter->international,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-location-horizontal', [
                'street'     => old('street') ?? $recruiter->street,
                'street2'    => old('street2') ?? $recruiter->street2,
                'city'       => old('city') ?? $recruiter->city,
                'state_id'   => old('state_id') ?? $recruiter->state_id,
                'states'     => new State()->listOptions([], 'id', 'name', true),
                'zip'        => old('zip') ?? $recruiter->zip,
                'country_id' => old('country_id') ?? $recruiter->country_id,
                'countries'  => new Country()->listOptions([], 'id', 'name', true),
                'message'    => $message ?? '',
            ])

            @include('admin.components.form-coordinates-horizontal', [
                'latitude'  => old('latitude') ?? $recruiter->latitude,
                'longitude' => old('longitude') ?? $recruiter->longitude,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-phone-horizontal', [
                'phone' => old('phone') ?? $recruiter->phone,
                'label' => old('phone_label') ?? $recruiter->phone_label,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-phone-horizontal', [
                'phone'   => old('alt_phone') ?? $recruiter->alt_phone,
                'label'   => old('alt_phone_label') ?? $recruiter->alt_phone_label,
                'alt'     => true,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-email-horizontal', [
                'email'   => old('email') ?? $recruiter->email,
                'label'   => old('email_label') ?? $recruiter->email_label,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-email-horizontal', [
                'email'   => old('alt_email') ?? $recruiter->alt_email,
                'label'   => old('alt_email_table') ?? $recruiter->alt_email_label,
                'alt'     => true,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $recruiter->link,
                'name' => old('link_name') ?? $recruiter->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $recruiter->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $recruiter->image,
                'credit'  => old('image_credit') ?? $recruiter->image_credit,
                'source'  => old('image_source') ?? $recruiter->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $recruiter->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'sequence',
                'value'       => old('sequence') ?? $recruiter->sequence,
                'min'         => 0,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'public'      => old('public')   ?? $recruiter->public,
                'readonly'    => old('readonly') ?? $recruiter->readonly,
                'root'        => old('root')     ?? $recruiter->root,
                'disabled'    => old('disabled') ?? $recruiter->disabled,
                'demo'        => old('demo')     ?? $recruiter->demo,
                'sequence'    => old('sequence') ?? $recruiter->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.recruiter.index')
            ])

        </form>

    </div>

@endsection
