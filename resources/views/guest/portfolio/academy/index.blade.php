@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\Academy';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? 'Online Learning';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Online Learning' ],
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

    <?php /*
    @include('guest.components.search-panel.portfolio-academy', [ 'owner_id' => $owner->id ?? null ])
    */ ?>

    <div class="floating-div-container">

        <div class="show-container card floating-div" style="width: 20rem;">

            <p><i>{{ number_format($academies->total()) }} {{ ($academies->total() === 1) ? 'academy' : 'academies' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $academies->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

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
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($academies as $academy)

                    <tr>
                        <td style="white-space: nowrap;">
                            <span {!! $academy->featured ? 'class="has-text-weight-bold"' : '' !!}>
                                {{ $academy->name }}
                            </span>
                            @if (!empty($academy->link))
                                @include('admin.components.link-icon', [
                                    'title'  => 'open link in new window',
                                    'href'   => $academy->link,
                                    'icon'   => 'fa-external-link',
                                    'border' => false,
                                    'target' => '_blank'
                                ])
                            @endif
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5">No academies found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $academies->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
