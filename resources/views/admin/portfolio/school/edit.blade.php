@php
    use App\Models\Portfolio\School;
    use App\Models\System\Country;
    use App\Models\System\Owner;
    use App\Models\System\State;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $school      = $school ?? null;

    $title    = 'Edit ' . getResourcePageTitle($school);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                               'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                    'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',                          'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Schools',                            'href' => route('admin.portfolio.school.index') ],
        [ 'name' => getResourcePageTitle($school, false), 'href' => route('admin.portfolio.school.show', $school) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.school.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.portfolio.school.update', array_merge([$school], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.portfolio.school.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $school->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $school->id,
                    'hide'  => !$isRootAdmin,
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $school->name,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'      => 'summary',
                    'value'     => old('summary') ?? $school->summary,
                    'maxlength' => 500,
                    'cols'      => 30,
                    'rows'      => 5,
                    'message'   => $message ?? '',
                    'class'     => [ 'textarea-summary' ],
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'type',
                    'value'   => old('type') ?? $school->type,
                    'list'    => new School()->typeListOptions(true),
                    'message' => $message ?? '',
                    'style'   => [ 'width: 4rem' ],
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'gender',
                    'value'   => old('gender') ?? $school->gender,
                    'list'    => new School()->genderListOptions(),
                    'message' => $message ?? '',
                    'style'   => [ 'width: 4rem' ],
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'        => 'number',
                    'name'        => 'enrollment',
                    'value'       => old('enrollment') ?? $school->enrollment,
                    'min'         => 0,
                    'message'     => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'        => 'number',
                    'name'        => 'founded',
                    'value'       => old('founded') ?? $school->founded,
                    'min'         => 0,
                    'message'     => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-location-horizontal', [
                    'street'     => old('street') ?? $school->street,
                    'street2'    => old('street2') ?? $school->street2,
                    'city'       => old('city') ?? $school->city,
                    'state_id'   => old('state_id') ?? $school->state_id,
                    'states'     => new State()->listOptions([], 'id', 'name', true),
                    'zip'        => old('zip') ?? $school->zip,
                    'country_id' => old('country_id') ?? $school->country_id,
                    'countries'  => new Country()->listOptions([], 'id', 'name', true),
                    'message'    => $message ?? '',
                ])

                @include('admin.components.form-coordinates-horizontal', [
                    'latitude'  => old('latitude') ?? $school->latitude,
                    'longitude' => old('longitude') ?? $school->longitude,
                    'message'   => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-link-horizontal', [
                    'link'    => old('link') ?? $school->link,
                    'name'    => old('link_name') ?? $school->link_name,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $school->description,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea description' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.show-row-images', [
                    'resource' => $school,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'value'   => old('notes') ?? $school->notes,
                    'message' => $message ?? '',
                    'class'    => [ 'textarea-notes' ]
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $school->is_public,
                    'is_readonly' => old('is_readonly') ?? $school->is_readonly,
                    'is_root'     => old('is_root')     ?? $school->root,
                    'is_disabled' => old('is_disabled') ?? $school->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $school->is_demo,
                    'sequence'    => old('sequence')    ?? $school->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.portfolio.school-task.index')
        ])

    </form>

@endsection
