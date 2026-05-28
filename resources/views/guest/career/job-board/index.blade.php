@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Career\JobBoard';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = 'Job Boards';
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

    <div class="floating-div-container">

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
                        <th>free</th>
                        <th>premium*</th>
                        <th>staffing**</th>
                        <th>freelance***</th>
                        <th>description</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($jobBoards as $jobBoard)

                    <tr>
                        <td style="white-space: nowrap;{{ $jobBoard->primary ? ' font-weight: 700;' : '' }}">
                            @if (!empty($jobBoard->link))
                                @include('guest.components.link', [
                                    'name'   => $jobBoard->name,
                                    'href'   => $jobBoard->link,
                                    'target' => '_blank'
                                ])
                            @else
                                <span style="font-weight: 700;">{{ $jobBoard->name }}</span>
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
                        <td style="white-space: nowrap;">
                            {!! $jobBoard->summary !!}
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
