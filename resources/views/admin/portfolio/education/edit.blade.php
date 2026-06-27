@php
    use App\Models\Portfolio\DegreeType;
    use App\Models\Portfolio\School;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $education   = $education ?? null;

    $title    = 'Edit ' . getResourcePageTitle($education);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                               'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                    'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                            'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',                             'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Education',                             'href' => route('admin.portfolio.education.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($education, false), 'href' => route('admin.portfolio.education.show', $education) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.education.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.portfolio.education.update', array_merge([$education], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.portfolio.education.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $education->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $education->id,
                    'hide'  => !$isRootAdmin,
                ])

                @if ($isRootAdmin)
                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'owner_id',
                        'label'    => 'owner',
                        'value'    => old('owner_id') ?? $education->owner_id,
                        'required' => true,
                        'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                        'message'  => $message ?? '',
                        'class'    => [ 'select-owner' ]
                    ])
                @else
                    @include('admin.components.form-hidden', [
                        'name'  => 'owner_id',
                        'value' => $education->owner_id
                    ])
                @endif

                @include('admin.components.form-select-horizontal', [
                    'name'     => 'degree_type_id',
                    'label'    => 'degree type',
                    'value'    => old('degree_type_id') ?? $education->degree_type_id,
                    'required' => true,
                    'list'     => new DegreeType()->listOptions([], 'id', 'name', true, false, [ 'name', 'asc' ]),
                    'message'  => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'major',
                    'value'     => old('major') ?? $education->major,
                    'required'  => false,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'minor',
                    'value'     => old('minor') ?? $education->minor,
                    'required'  => false,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'      => 'school_id',
                    'label'     => 'school',
                    'value'     => old('school_id') ?? $education->school_id,
                    'list'      => new School()->listOptions([], 'id', 'name', true),
                    'required'  => true,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'month',
                    'name'      => 'enrollment_date',
                    'label'     => 'enrollment date',
                    'value'     => old('enrollment_date') ?? !empty($education->enrollment_date)
                                                                 ? substr($education->enrollment_date, 0, -3)
                                                                 : '',
                    'min'       => '1970-01',
                    'max'       => date("Y-m"),
                    'message'   => $message ?? '',
                    'style'     => 'width: 12rem;',
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'graduated',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('graduated') ?? $education->graduated,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'month',
                    'name'      => 'graduation_date',
                    'label'     => 'graduation date',
                    'value'     => old('graduation_date') ?? !empty($education->graduation_date)
                                                                 ? substr($education->graduation_date, 0, -3)
                                                                 : '',
                    'min'       => '1970-01',
                    'max'       => date("Y-m"),
                    'message'   => $message ?? '',
                    'style'     => 'width: 12rem;',
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'currently_enrolled',
                    'label'           => 'currently enrolled',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('currently_enrolled') ?? $education->currently_enrolled,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'      => 'summary',
                    'value'     => old('summary') ?? $education->summary,
                    'maxlength' => 500,
                    'cols'      => 30,
                    'rows'      => 5,
                    'message'   => $message ?? '',
                    'class'     => [ 'textarea-summary' ],
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-link-horizontal', [
                    'link'    => old('link') ?? $education->link,
                    'name'    => old('link_name') ?? $education->link_name,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $education->description,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-description' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-textarea-horizontal', [
                    'name'      => 'disclaimer',
                    'value'     => old('disclaimer') ?? $education->disclaimer,
                    'maxlength' => 500,
                    'cols'      => 30,
                    'rows'      => 3,
                    'message'   => $message ?? '',
                    'class'     => [ 'textarea-disclaimer' ],
                ])

                @include('admin.components.show-row-images', [
                    'resource' => $education,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'value'   => old('notes') ?? $education->notes,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-notes' ]
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $education->is_public,
                    'is_readonly' => old('is_readonly') ?? $education->is_readonly,
                    'is_root'     => old('is_root')     ?? $education->root,
                    'is_disabled' => old('is_disabled') ?? $education->is_disabled,
                    'is_emo'      => old('is_demo')     ?? $education->is_demo,
                    'sequence'    => old('sequence')    ?? $education->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.portfolio.education.index')
        ])

    </form>

@endsection
