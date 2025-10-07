@extends('guest.layouts.default', [
    'title' => $title ?? 'My Resume',
    'breadcrumbs' => [
        [ 'name' => 'Home',      'href' => route('guest.homepage') ],
        [ 'name' => $title ?? 'My Resume' ],
    ],
    'buttons' => [],
    'errors'  => $errors->any()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="resume-container card p-4">

        @foreach($jobs as $job)

            <div class="list-item-content mb-3 border-bottom">

                <div class="list-item-title">
                    {{ $job->role }}
                </div>

                <div class="list-item-description">
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

                <div class="list-item-description pt-2">
                    @if(!empty($job->tasks))
                        <ul>
                        @foreach($job->tasks as $task)
                            <li>{{ $task->summary }}</li>
                        @endforeach
                        </ul>
                    @endif
                    {{ $job->summary }}
                </div>

            </div>

        @endforeach

    </div>

@endsection
