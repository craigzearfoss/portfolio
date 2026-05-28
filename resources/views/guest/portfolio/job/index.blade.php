@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\Job';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('jobs', htmlspecialchars($owner->name));
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Job' ],
          ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @if ($owner->is_demo)
        @if ($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => htmlspecialchars($disclaimerMessage) ])
        @endif
    @endif

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @forelse ($jobs as $i=>$job)

                <div class="list-item-content mb-3 border-bottom is-flex"
                     @if ($i > 0)
                         style="border-top:#eee 1px inset; padding-top: 0.4em; max-width: 900px;"
                    @else
                         style="max-width: 900px;"
                    @endif
                >

                    <div class=" is-align-items-flex-start" style="display: inline-block; width: 56px; margin-right: 0.5em;">
                        @include($envType->value . '.components.image', [
                            'src'   => $job->logo_small,
                            'alt'   => (!empty($job->company) ? htmlspecialchars($job->company) : 'company') . ' logo',
                            'width' => '48px',
                        ])
                    </div>

                    <div style="display: inline-block; width: 100%; max-width: 840px;">

                        <div style="display: inline-block; width: 100%;">

                            <div class="list-item-title" style="display: inline-block; float: left;">
                                <strong>{!! htmlspecialchars($job->role) !!}</strong>
                            </div>

                            <div class="list-item-description gray" style="display: inline-block; float: right;">
                                <div>
                                    @php
                                        $rangeData = dateRangeDetails($job->start_date, $job->end_date, true, false);
                                    @endphp
                                    {!! $rangeData['start'] . ' - ' . $rangeData['end'] . ' · ' . $rangeData['range'] !!}
                                </div>
                            </div>

                        </div>

                        <div style="display: inline-block; width: 100%;">

                            <div class="list-item-description p-0" style="display: inline-block; float: left;">
                                <i style="font-weight: 600;">{!! htmlspecialchars($job->company) !!}</i> · {!! htmlspecialchars($job->employmentType->name ?? '') !!}
                            </div>

                            <div class="list-item-description gray" style="display: inline-block; float: right;">
                                <div>
                                    {!!
                                        formatLocation([
                                            'city'  => htmlspecialchars($job->city),
                                            'state' => $job->state->code ?? ''
                                        ])
                                    !!}
                                    <div class="tag is-rounded">
                                        {!! htmlspecialchars($job->locationType->name) !!}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="list-item-description pt-0">
                            {!! htmlspecialchars($job->summary) !!}
                        </div>

                        <div class="list-item-description pt-1">
                            @if (!empty($job->tasks))
                                <ul class="job-tasks">
                                    @foreach ($job->tasks as $task)
                                        <li>• {!! htmlspecialchars($task->summary) !!}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        @if ($job->skills->count() > 0)

                            <div class="list-item-description pt-2">
                                <strong>Skills:</strong>
                                {!! htmlspecialchars(implode(' · ', array_column($job->skills->toArray(), 'name'))) !!}
                            </div>

                        @endif

                    </div>

                </div>

            @empty

                    <tr>
                        <td colspan="7">No jobs found.</td>
                    </tr>

            @endforelse

            {!! $jobs->links('vendor.pagination.bulma') !!}

        </div>

    </div>

@endsection
