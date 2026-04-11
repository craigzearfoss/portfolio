@php
    use App\Models\Dictionary\Category;
    use App\Models\System\Owner;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $skill       = $skill ?? null;

    $title    = $pageTitle ?? 'Add New Skill';
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
        $breadcrumbs[] = [ 'name' => 'Skills',     'href' => route('admin.portfolio.skill.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Skills',     'href' => route('admin.portfolio.skill.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Add' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.skill.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.skill.store', request()->all()) }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.skill.index')
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

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'version',
                'value'     => old('version') ?? '',
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'featured',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('featured') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'summary',
                'value'     => old('summary') ?? '',
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'dictionary_category_id',
                'label'    => 'category',
                'value'    => old('dictionary_category_id') ?? '',
                'required' => true,
                'list'     => new Category()->listOptions([], 'id', 'name', true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'level',
                'label'       => 'level (1 to 10)',
                'value'       => old('level') ?? 1,
                'min'         => 1,
                'max'         => 10,
                'required'    => true,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'number',
                'name'      => 'start_year',
                'label'     => 'start year',
                'value'     => old('start_year') ?? '',
                'min'       => 1980,
                'max'       => date("Y"),
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'number',
                'name'      => 'end_year',
                'label'     => 'end year',
                'value'     => old('end_year') ?? '',
                'min'       => 1980,
                'max'       => date("Y"),
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'years',
                'value'       => old('years') ?? 0,
                'min'         => 0,
                'message'     => $message ?? '',
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
                'label'      => 'Add Skill',
                'cancel_url' => referer('admin.portfolio.skill.index')
            ])

        </form>

    </div>

@endsection
