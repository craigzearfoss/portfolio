@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Career\JobBoard';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? 'Job Boards';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home', 'href' => route('guest.index') ],
            [ 'name' => 'Job Boards' ],
          ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    <?php /*
    @if ($owner->is_demo)
        @if ($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => htmlspecialchars($disclaimerMessage) ])
        @endif
    @endif
    */ ?>

    <div class="floating-div-container" style="max-width: 50rem !important;">

        <div class="show-container card floating-div">

            <p><i>{{ number_format($jobBoards->total()) }} {{ ($jobBoards->total() === 1) ? 'record' : 'records' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $jobBoards->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        <th>name</th>
                        <th class="has-text-centered" style="width: 2rem;">free</th>
                        <th class="has-text-centered" style="width: 2rem;">premium*</th>
                        <th class="has-text-centered" style="width: 2rem;">staffing**</th>
                        <th class="has-text-centered">freelance***</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($jobBoards as $jobBoard)

                    <tr>
                        <td style="white-space: nowrap;{{ $jobBoard->primary ? ' font-weight: 700;' : '' }}">
                            <span {!! $jobBoard->featured ? 'class="has-text-weight-bold"' : '' !!}>
                                {{ $jobBoard->name }}
                            </span>
                            @if (!empty($jobBoard->jobs_url) || !empty($jobBoard->link))
                                @include('admin.components.link-icon', [
                                    'title'  => 'open link in new window',
                                    'href'   => !empty($jobBoard->jobs_url) ? $jobBoard->jobs_url : $jobBoard->link,
                                    'icon'   => 'fa-external-link',
                                    'border' => false,
                                    'target' => '_blank'
                                ])
                            @endif
                        </td>
                        <td class="has-text-centered">
                            @include('guest.components.checkmark', [ 'checked' => $jobBoard->free ])
                        </td>
                        <td class="has-text-centered">
                            @include('guest.components.checkmark', [ 'checked' => $jobBoard->premium ])
                        </td>
                        <td class="has-text-centered">
                            @include('guest.components.checkmark', [ 'checked' => $jobBoard->staffing ])
                        </td>
                        <td class="has-text-centered">
                            @include('guest.components.checkmark', [ 'checked' => $jobBoard->freelance ])
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7">No job boards found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            <p class="is-size-7"><i>* offers a premium or subscription-based service, ** offers staffing services, *** has a marketplace for freelance workers</i></p>

            @if (!empty($pagination_bottom))
                {!! $jobBoards->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
