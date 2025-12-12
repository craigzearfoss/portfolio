@extends('guest.layouts.default', [
    'title' => $title ?? $admin->name . ' resume',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => $title ?? 'Resume' ],
    ],
    'buttons' => [],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $resume->disclaimer ?? null ])

    <div class="resume-container card p-4">

        @foreach($jobs as $i=>$job)

            <div class="list-item-content mb-3 border-bottom is-flex"
                 @if($i > 0)
                    style="border-top:#eee 1px inset; padding-top: 0.4em"
                 @endif
            >

                <div class=" is-align-items-flex-start" style="display: inline-block; width: 56px; margin-right: 0.5em;">
                    @include('admin.components.image', [
                        'src'   => $job->logo_small,
                        'alt'   => ($job->company->name ?? 'company') . ' logo',
                        'width' => '48px',
                    ])
                </div>

                <div style="display: inline-block;">

                    <div class="list-item-title">
                        {{ $job->role }}
                    </div>

                    <div class="list-item-description pt-1 pb-1">
                        {{ $job->company }} · {{ $job->employmentType->name ?? '' }}
                    </div>

                    <div class="list-item-description gray">
                        <div>
                            @php
                                $rangeData = dateRangeDetails(
                                    $job->start_year . (!empty($job->start_month) ? '-' . $job->start_month : ''),
                                    $job->end_year . (!empty($job->end_month) ? '-' . $job->end_month : '')
                                );
                            @endphp
                            {{ $rangeData['start'] . ' - ' . $rangeData['end'] . ' · ' . $rangeData['range'] }}
                        </div>
                    </div>

                    <div class="list-item-description gray">
                        <div>
                            {{
                                formatLocation([
                                    'city'  => $job->city ?? null,
                                    'state' => $job->state['code'] ?? null
                                ])
                            }}
                            <div class="tag is-rounded">
                                {{ $job->locationType['name'] ?? '' }}
                            </div>
                        </div>
                    </div>

                    <div class="list-item-description pt-2">
                        {{ $job->summary }}
                    </div>

                    <div class="list-item-description pt-1">
                        @if(!empty($job->tasks))
                            <ul>
                            @foreach($job->tasks as $task)
                                <li>• {{ $task->summary }}</li>
                            @endforeach
                            </ul>
                        @endif
                    </div>

                    @if($job->skills->count() > 0)

                        <div class="list-item-description pt-2">
                            <strong>Skills:</strong>
                            {{ implode(' · ', array_column($job->skills->toArray(), 'name')) }}
                        </div>

                    @endif

                </div>

            </div>

        @endforeach


        @if($educations->count() > 0)

            <h2 class="title is-5 mt-4 pt-2 mb-1">Education</h2>

            @foreach($educations as $i=>$education)

                <div class="list-item-content mb-3 border-bottom is-flex pl-4"
                     @if($i > 0)
                         style="border-top:#eee 1px inset; padding-top: 0.4em"
                    @endif
                >
                    <div style="display: inline-block;">

                        <div class="list-item-description pt-1">
                            {{ $education->degreeType->name }} in {{ $education->major }}
                            -
                            {{ (months()[$education->graduation_month] ?? '') }}, {{ $education->graduation_year }}
                        </div>

                        <div class="list-item-description pt-1">
                            {{ $education->school->name ?? '' }}
                        </div>

                    </div>

                </div>

            @endforeach

        @endif


        @if($certificates->count() > 0)

            <h2 class="title is-5 mt-4 pt-2 mb-1">Certifications</h2>

            @foreach($certificates as $i=>$certificate)

                <div class="list-item-content mb-3 border-bottom is-flex pl-4"
                     @if($i > 0)
                         style="border-top:#eee 1px inset; padding-top: 0.4em"
                    @endif
                >
                    <div style="display: inline-block;">

                        <div class="list-item-description pt-1">
                            {{ $certificate->name }}
                            -
                            {{ longDate($certificate->received) }}
                        </div>

                    </div>

                </div>

            @endforeach

        @endif


        @if($skills->count() > 0)

            <h2 class="title is-5 mt-4 pt-2 mb-1">Skills</h2>

            <div class="list-item-content mb-3 border-bottom is-flex pl-4">

                <div class="list-item-description pt-1">

                    <span style="min-width: 9em; display: inline-block;"> ·
                        {!! implode('</span><span style="min-width: 9em; display: inline-block;"> · ', array_column($skills->toArray(), 'name')) !!}
                    </span>

                </div>

            </div>

        @endif

    </div>

@endsection
