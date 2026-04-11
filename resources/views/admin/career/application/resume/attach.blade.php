@php
    use App\Models\Career\Resume;

    $title    = $pageTitle ?? 'Attach a resume' . (!empty($application) ? ' to ' . $application->name . ' application' : '');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && $isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',           'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name,       'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Career',           'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Applications',     'href' => route('admin.career.application.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => $application->name, 'href' => route('admin.career.application.show', [$application, 'owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Career',           'href' => route('admin.career.index') ];
        $breadcrumbs[] = [ 'name' => 'Applications',     'href' => route('admin.career.application.index') ];
        $breadcrumbs[] = [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application) ];
    }
    $breadcrumbs[] = [ 'name' => 'Attach Resume' ];

    // set navigation buttons
    $navButtons = [];
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.career.application.index')])->render();

    $resumeOptionsList = new Resume()->listOptions([], 'id', 'name', true);

    $selectedResumeId = !empty($errors->any()) || !empty($errors->get('GLOBAL'))
        ? null
        : old('resume_id') ?? $application->resume_id ?? null
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4 has-text-centered" style="width: 32rem">

        @if (!empty($resumeOptionsList))

            <form action="{{ route('admin.career.application.resume.attach.store', $application) }}"
                  method="POST">
                @csrf

                @include('admin.components.form-hidden', [
                    'name'  => 'referer',
                    'value' => referer('admin.career.application.index')
                ])

                @include('admin.components.form-hidden', [
                    'name'  => 'application_id',
                    'value' => $application->id
                ])

                @include('admin.components.form-select', [
                    'name'     => 'resume_id',
                    'label'    => 'Select a resume',
                    'value'    => $selectedResumeId,
                    'required' => true,
                    'list'     => $resumeOptionsList,
                    'onchange' => "document.getElementById('selectCompanyForm').submit();",
                    'message'  => $message ?? '',
                    'style'    => [ 'width: 30rem !important', 'min-width: 30rem !important'  ]
                ])

                @include('admin.components.form-button-submit-horizontal', [
                    'label'      => 'Attach',
                    'cancel_url' => referer('admin.career.application.show', $application)
                ])

            </form>

        @else

            <p>You currently have no resumes so you will have to create one.</p>

            @include('admin.components.link', [
                'name'  => 'Add a new resume',
                'href'  => route(
                                'admin.career.resume.create',
                                !empty($application->id) ? ['application_id' => $application->id] : []
                            ),
                'class'    => 'button is-primary my-0',
            ])

        @endif

    </div>

@endsection
