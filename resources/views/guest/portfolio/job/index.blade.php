@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Job' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? $owner->name . ' jobs',
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="card p-4">


        @forelse ($jobs as $i=>$job)

            <div class="list-item-content mb-3 border-bottom is-flex"
                 @if($i > 0)
                     style="border-top:#eee 1px inset; padding-top: 0.4em; max-width: 900px;"
                @else
                     style="max-width: 900px;"
                @endif
            >

                <div class=" is-align-items-flex-start" style="display: inline-block; width: 56px; margin-right: 0.5em;">
                    @include($envType . '.components.image', [
                        'src'   => $job->logo_small,
                        'alt'   => (!empty($job->company) ?$job->company : 'company') . ' logo',
                        'width' => '48px',
                    ])
                </div>

                <div style="display: inline-block; width: 100%; max-width: 840px;">

                    <div style="display: inline-block; width: 100%;">

                        <div class="list-item-title" style="display: inline-block; float: left;">
                            <strong>{!! $job->role !!}</strong>
                        </div>

                        <div class="list-item-description gray" style="display: inline-block; float: right;">
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

                    </div>

                    <div style="display: inline-block; width: 100%;">

                        <div class="list-item-description p-0" style="display: inline-block; float: left;">
                            <i style="font-weight: 600;">{!! $job->company !!}</i> · {!! $job->employmentType->name ?? '' !!}
                        </div>

                        <div class="list-item-description gray" style="display: inline-block; float: right;">
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

                    </div>

                    <div class="list-item-description pt-0">
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

        @empty

                <tr>
                    <td colspan="7">There are no jobs.</td>
                </tr>

        @endforelse

        {!! $jobs->links('vendor.pagination.bulma') !!}

    </div>

@endsection
