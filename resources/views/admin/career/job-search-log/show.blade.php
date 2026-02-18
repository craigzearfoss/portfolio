@php
    use App\Enums\PermissionEntityTypes;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',         'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name,     'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Career',         'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Job Search Log', 'href' => route('admin.career.job-search-log.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Career',         'href' => route('admin.career.index') ];
        $breadcrumbs[] = [ 'name' => 'Job Search Log', 'href' => route('admin.career.job-search-log.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Log Entry' ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'job-search-log', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Log Entry', 'href' => route('admin.career.job-search-log.create', $owner ?? $admin)])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.career.job-search-log.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Log Entry',
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $jobSearchLog->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $jobSearchLog->owner->username
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $jobSearchLog->time_logged
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $jobSearchLog->message
        ])

        @include('admin.components.show-row', [
            'name'  => 'application',
            'value' => $jobSearchLog->application->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'cover letter',
            'value' => $jobSearchLog->coverLetter->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'resume',
            'value' => $jobSearchLog->resume->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'company',
            'value' => $jobSearchLog->company->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'contact',
            'value' => $jobSearchLog->contact->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'communication',
            'value' => $jobSearchLog->communication->subject
        ])

        @include('admin.components.show-row', [
            'name'  => 'event',
            'value' => $jobSearchLog->event->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'note',
            'value' => $jobSearchLog->note->subject
        ])

        @include('admin.components.show-row', [
            'name'  => 'recruiter',
            'value' => $jobSearchLog->recruiter->name
        ])

    </div>

@endsection
