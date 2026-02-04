@php
    $envType = (explode('.', Route::currentRouteName())[0] == 'admin') ? 'admin' : 'guest';

    $breadcrumbs = [];
    $breadcrumbs[] = [ 'name' => 'Home',       'href' => route('admin.index') ];
    if ($envType == 'admin') {
        $breadcrumbs[] = [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ];
        $breadcrumbs[] = [ 'name' => 'Career',           'href' => route('admin.career.index') ];
        $breadcrumbs[] = [ 'name' => 'Resumes',          'href' => route('admin.career.resume.index') ];
        $breadcrumbs[] = [ 'name' => $title ?? 'Preview'];
    } else {
        $breadcrumbs[] = [ 'name' => 'Candidates',       'href' => route('guest.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name,       'href' => route('guest.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => $title ?? 'Resume'];
    }
@endphp
@extends($envType . '.layouts.default', [
    'title'            => $pageTitle ?? $owner->name . ' resume',
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => [],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    @if($envType != 'admin')
        @include('guest.components.disclaimer', [ 'value' => $resume->disclaimer ?? null ])
    @endif

    <div class="resume-container card p-4">

        @foreach($resumeService->jobs as $i=>$job)

            <div class="list-item-content mb-3 border-bottom is-flex"
                 @if($i > 0)
                     style="border-top:#eee 1px inset; padding-top: 0.4em"
                @endif
            >

                <div class=" is-align-items-flex-start" style="display: inline-block; width: 56px; margin-right: 0.5em;">
                    @include($envType . '.components.image', [
                        'src'   => $job->logo_small,
                        'alt'   => (!empty($job->company) ?$job->company : 'company') . ' logo',
                        'width' => '48px',
                    ])
                </div>

                <div style="display: inline-block;">

                    <div class="list-item-title">
                        {!! $job->role !!}
                    </div>

                    <div class="list-item-description pt-1 pb-1">
                        {!! $job->company !!} · {!! $job->employmentType->name ?? '' !!}
                    </div>

                    <div class="list-item-description gray">
                        <div>
                            @php
                                $rangeData = dateRangeDetails(
                                    $job->start_year . (!empty($job->start_month) ? '-' . $job->start_month : ''),
                                    $job->end_year . (!empty($job->end_month) ? '-' . $job->end_month : '')
                                );
                            @endphp
                            {!! $rangeData['start'] . ' - ' . $rangeData['end'] . ' · ' . $rangeData['range'] !!}
                        </div>
                    </div>

                    <div class="list-item-description gray">
                        <div>
                            {!!
                                formatLocation([
                                    'city'  => $job->city,
                                    'state' => $job->state->code
                                ])
                            !!}
                            <div class="tag is-rounded">
                                {!! $job->locationType->name !!}
                            </div>
                        </div>
                    </div>

                    <div class="list-item-description pt-2">
                        {!! $job->summary !!}
                    </div>

                    <div class="list-item-description pt-1">
                        @if(!empty($job->tasks))
                            <ul>
                                @foreach($job->tasks as $task)
                                    <li>• {!! $task->summary !!}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    @if($job->skills->count() > 0)

                        <div class="list-item-description pt-2">
                            <strong>Skills:</strong>
                            {!! implode(' · ', array_column($job->skills->toArray(), 'name')) !!}
                        </div>

                    @endif

                </div>

            </div>

        @endforeach


        @if($resumeService->educations->count() > 0)

            <h2 class="title is-5 mt-4 pt-2 mb-1">Education</h2>

            @foreach($resumeService->educations as $i=>$education)

                <div class="list-item-content mb-3 border-bottom is-flex pl-4"
                     @if($i > 0)
                         style="border-top:#eee 1px inset; padding-top: 0.4em"
                    @endif
                >
                    <div style="display: inline-block;">

                        <div class="list-item-description pt-1">
                            {!! $education->degreeType->name ?? '' !!} in {!! $education->major !!}
                            -
                            {!! (months()[$education->graduation_month] ?? '') !!}, {!! $education->graduation_year !!}
                        </div>

                        <div class="list-item-description pt-1">
                            {!! $education->school->name !!}
                        </div>

                    </div>

                </div>

            @endforeach

        @endif


        @if($resumeService->certificates->count() > 0)

            <h2 class="title is-5 mt-4 pt-2 mb-1">Certifications</h2>

            @foreach($resumeService->certificates as $i=>$certificate)

                <div class="list-item-content mb-3 border-bottom is-flex pl-4"
                     @if($i > 0)
                         style="border-top:#eee 1px inset; padding-top: 0.4em"
                    @endif
                >
                    <div style="display: inline-block;">

                        <div class="list-item-description pt-1">
                            {!! $certificate->name !!}
                            -
                            {!! longDate($certificate->received) !!}
                        </div>

                    </div>

                </div>

            @endforeach

        @endif


        @if($resumeService->awards->count() > 0)

            <h2 class="title is-5 mt-4 pt-2 mb-1">Awards</h2>

            @foreach($resumeService->awards as $i=>$award)

                <div class="list-item-content border-bottom is-flex pl-4">
                    <div style="display: inline-block;">

                        <div class="list-item-description pt-1">
                            {!! $award->year !!}
                            {!! $award->name !!}{!! empty($award->category) ? ', ' . $award->category : '' !!}
                            {!! !empty($award->nominated_work) ? 'for ' . $award->nominated_work : '' !!}
                            {!! (!empty($award->organization) && empty($award->category)) ? '- ' . $award->organization : '' !!}
                        </div>

                    </div>

                </div>

            @endforeach

        @endif


        @if($resumeService->skills->count() > 0)

            <h2 class="title is-5 mt-4 pt-2 mb-1">Skills</h2>

            <div class="list-item-content mb-3 border-bottom is-flex pl-4">

                <div class="list-item-description pt-1">

                    <span class="mr-1" style="display: inline-block;"> ·
                        {!! implode('</span><span class="mr-1" style="display: inline-block;"> · ', array_column($resumeService->skills->toArray(), 'name')) !!}
                    </span>

                </div>

            </div>

        @endif

    </div>

@endsection
