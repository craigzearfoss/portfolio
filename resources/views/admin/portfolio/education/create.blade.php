@php
    use App\Models\Portfolio\DegreeType;
    use App\Models\Portfolio\School;
    use App\Models\System\Owner;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $education   = $education ?? null;

    $title    = $pageTitle ?? 'Add New Education';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && $isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Education',  'href' => route('admin.portfolio.education.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Education',  'href' => route('admin.portfolio.education.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Add' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.education.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.education.store', request()->all()) }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.education.index')
            ])

            @if($isRootAdmin)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? '',
                    'required' => true,
                    'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => Auth::guard('admin')->user()->id
                ])
            @endif

            @include('admin.components.form-select-horizontal', [
                'name'     => 'degree_type_id',
                'label'    => 'degree type',
                'value'    => old('degree_type_id') ?? '',
                'required' => true,
                'list'     => new DegreeType()->listOptions([], 'id', 'name', true, false, [ 'name', 'asc' ]),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'major',
                'value'     => old('major') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'minor',
                'value'     => old('minor') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'      => 'school_id',
                'label'     => 'school',
                'value'     => old('school_id') ?? '',
                'list'      => new School()->listOptions([], 'id', 'name', true),
                'required'  => true,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'month',
                'name'      => 'enrollment_date',
                'label'     => 'enrollment date',
                'value'     => old('enrollment_date') ?? '',
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
                'value'     => old('graduation_date') ?? '',
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
                'checked'         => old('currently_enrolled') ?? '',
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'summary',
                'value'     => old('summary') ?? '',
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? '',
                'name' => old('link_name') ?? '',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? '',
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? 0,
                'is_readonly' => old('is_readonly') ?? 0,
                'is_root'     => old('is_root')     ?? 0,
                'is_disabled' => old('is_disabled') ?? 0,
                'is_demo'     => old('is_demo')     ?? 0,
                'sequence'    => old('sequence')    ?? 0,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Add Education',
                'cancel_url' => referer('admin.portfolio.education.index')
            ])

        </form>

    </div>

@endsection
