@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\Certificate';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('certificates', htmlspecialchars($owner->name));
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Certificate' ],
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

    @include('guest.components.search-panel.portfolio-certificate', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            <p><i>{{ number_format($certificates->total()) }} {{ ($certificates->total() === 1) ? 'certificate' : 'certificates' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $certificates->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}" style="min-width: 40rem; max-width: 80rem; overflow-x: auto; overflow-y: hidden;">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'name',
                                'sort'  => 'name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'academy',
                                'sort'  => 'academy_name|asc',
                            ])
                        </th>
                        <th class="hide-at-900">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'organization',
                                'sort'  => 'organization|asc',
                            ])
                        </th>
                        <th class="has-text-centered hide-at-600">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'year',
                                'sort'  => 'certificate_year|asc',
                            ])
                        </th>
                        <th class="has-text-centered hide-at-750">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'received',
                                'sort'  => 'received|asc',
                            ])
                        </th>
                        <th class="has-text-centered hide-at-1200">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'expiration',
                                'sort'  => 'expiration|asc',
                            ])
                        </th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($certificates as $certificate)

                    <tr data-id="{{ $certificate->id }}" {!! $certificate->is_disabled ? 'class="disabled-text"' : '' !!}>
                        <td style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => htmlspecialchars($certificate->name),
                                'href'  => route('guest.portfolio.certificate.show', [$certificate->owner->label, $certificate->slug]),
                                'class' => $certificate->featured ? [ 'has-text-weight-bold' ] : []
                            ])
                            <?php /*
                            @include('admin.components.link-icon', [
                                'title'      => 'add to favorites',
                                'icon'       => 'fa-heart',
                                'border'     => false,
                                'target'     => '_blank',
                                'class'      => 'add-to-favorites',
                                'attributes' => [ 'data-resource' => 'portfolio.certificate', 'data-id' => $certificate->id ]
                            ])
                            */ ?>
                        </td>
                        <td style="white-space: nowrap;">
                            @if (!empty($certificate->academy->link))
                                {!! htmlspecialchars($certificate->academy->name) !!}
                            @else
                                @include('guest.components.link', [
                                    'name'   => htmlspecialchars($certificate->academy->name ?? ''),
                                    'href'   => $certificate->academy->link ?? '',
                                    'target' => '_blank',
                                ])
                            @endif
                        </td>
                        <td class="hide-at-900" style="white-space: nowrap;">
                            {!! htmlspecialchars($certificate->organization) !!}
                        </td>
                        <td class="has-text-centered hide-at-600">
                            {!! $certificate->certificate_year !!}
                        </td>
                        <td class="has-text-centered hide-at-1200">
                            {!! shortDate($certificate->received) !!}
                        </td>
                        <td class="has-text-centered hide-at-750">
                            {!! shortDate($certificate->expiration) !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="6">No certificates found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $certificates->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
