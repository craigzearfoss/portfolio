@php
    use App\Models\Portfolio\CertificationType;

    $title    = $pageTitle ?? 'Add New Certification';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Certifications',  'href' => route('admin.portfolio.certification.index') ],
        [ 'name' => 'Add' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.certification.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.certification.store', request()->all()) }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.certification.index')
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'abbreviation',
                'label'     => 'abbreviation',
                'value'     => old('abbreviation') ?? '',
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'certification_type_id',
                'label'    => 'certification type',
                'value'    => old('certification_type_id') ?? '',
                'required' => true,
                'list'     => new CertificationType()->listOptions([], 'id', 'name', true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'organization',
                'label'     => 'organization',
                'value'     => old('organization') ?? '',
                'maxlength' => 255,
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

            @include('admin.components.form-visibility-horizontal', [
                'public'      => old('public')   ?? 0,
                'readonly'    => old('readonly') ?? 0,
                'root'        => old('root')     ?? 0,
                'disabled'    => old('disabled') ?? 0,
                'demo'        => old('demo')     ?? 0,
                'sequence'    => old('sequence') ?? 0,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Add Certification',
                'cancel_url' => referer('admin.portfolio.certification.index')
            ])

        </form>

    </div>

@endsection
