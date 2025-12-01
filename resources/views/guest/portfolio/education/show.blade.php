@extends('guest.layouts.default', [
    'title' => $title ?? 'Education: ' . $education->degreeType->name . ' ' . $education->major,
    'breadcrumbs' => [
        [ 'name' => 'Home',           'href' => route('system.index') ],
        [ 'name' => 'Users',          'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name,     'href' => route('guest.admin.show', $admin) ],
        [ 'name' => 'Portfolio',      'href' => route('guest.admin.portfolio.show', $education->owner) ],
        [ 'name' => 'Education',      'href' => route('guest.admin.portfolio.education.index', $education->owner) ],
        [ 'name' => $education->degreeType->name . ' ' . $education->major ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.admin.portfolio.education.index', $education->owner) ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $education->disclaimer ?? null ])

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'degree type',
            'value' => $education->degreeType->name
        ])

        @include('guest.components.show-row', [
            'name'  => 'major',
            'value' => $education->major
        ])

        @include('guest.components.show-row', [
            'name'  => 'minor',
            'value' => $education->minor
        ])

        @include('admin.components.show-row', [
            'name'  => 'school',
            'value' => $education->school->name ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'enrollment',
            'value' => (!empty($education->enrollment_month) ? date('F', mktime(0, 0, 0, $education->enrollment_month, 10)) : '') . ' ' . $education->enrollment_year
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'graduated',
            'checked' => $education->graduated
        ])

        @include('admin.components.show-row', [
            'name'  => 'enrollment',
            'value' => (!empty($education->graduation_month) ? date('F', mktime(0, 0, 0, $education->graduation_month, 10)) : '') . ' ' . $education->graduation_year
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'currently enrolled',
            'checked' => $education->currently_enrolled
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $education->summary
        ])

    </div>

@endsection
