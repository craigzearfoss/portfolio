@extends('guest.layouts.default', [
    'title' => $title ?? $admin->name . ' resume',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.homepage') ],
        [ 'name' => $admin->name, 'href' => route('guest.user.index', $admin)],
        [ 'name' => $title ?? 'Resume' ],
    ],
    'buttons' => [],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="resume-container card p-4">

        @foreach($jobs as $i=>$job)

            <div class="list-item-content mb-3 border-bottom is-flex"
                 @if($i > 0)
                    style="border-top:#eee 1px inset; padding-top: 0.4em"
                 @endif
            >

                <div class=" is-align-items-flex-start" style="display: inline-block; width: 56px; margin-right: 0.5em;">
                    @include('admin.components.image', [
                    'src'   => $job->thumbnail,
                    'alt'   => $job->name,
                    'width' => '48px',
                ])

                </div>

                <div style="display: inline-block;">

                    <div class="list-item-title">
                        {{ $job->role }}
                    </div>

                    <div class="list-item-description pt-1 pb-1">
                        {{ $job->company }} · {{ $job->employmentType['name'] ?? '' }}
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

                </div>

            </div>

        @endforeach

    </div>

@endsection
