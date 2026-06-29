@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\School';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? 'Schools';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Schools' ],
          ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    <?php /*
    @if ($owner->is_demo)
        @if ($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
        @endif
    @endif
    */ ?>

    @include('guest.components.search-panel.portfolio-school', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            <p><i>{{ number_format($schools->total()) }} {{ ($schools->total() === 1) ? 'school' : 'schools' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $schools->links('vendor.pagination.bulma') !!}
            @endif

            <p class="is-size-7 mb-0"><i>cc - community college, hbcu -, tech - technical, med - medical, rel - religious, sem - seminary</i></p>

            <table class="table guest-table {{ $guestTableClasses ?? '' }}" style="min-width: 30rem; max-width: 70rem; overflow-x: auto; overflow-y: hidden;">

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
                                'name'  => 'city',
                                'sort'  => 'city|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'state',
                                'sort'  => 'state_name|asc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'founded',
                                'sort'  => 'founded|asc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            type
                        </th>
                        <th>
                            details
                        </th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($schools as $school)

                    <tr data-id="{{ $school->id }}" {{ $school->is_disabled ? 'class="disabled-text"' : '' }}>
                        <td data-field="name" style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => $school->name,
                                'href'  => route('guest.portfolio.school.show', [ $school->slug ]),
                            ])
                            @include('guest.components.link-icon', [
                                'title'      => 'add to favorites',
                                'icon'       => 'fa-heart',
                                'border'     => false,
                                'target'     => '_blank',
                                'class'      => 'add-to-favorites',
                                'attributes' => [ 'data-resource' => 'portfolio.school', 'data-id' => $school->id ]
                            ])
                            @if (!empty($school->link))
                                @include('guest.components.link-icon', [
                                    'title'  => 'open link in new window',
                                    'href'   => $school->link,
                                    'icon'   => 'fa-external-link',
                                    'border' => false,
                                    'target' => '_blank'
                                ])
                            @endif
                        </td>
                        <td data-field="state" style="white-space: nowrap;">
                            {{ $school->city }}
                        </td>
                        <td data-field="state" style="white-space: nowrap;">
                            {{ $school->state['name'] }}
                        </td>
                        <td data-field="founded" class="has-text-centered">
                            {{ $school->founded }}
                        </td>
                        <td data-field="type" class="has-text-centered" style="white-space: nowrap;">
                            {{ $school->type }}
                        </td>
                        <td data-field="details" style="min-width: 20rem;">
                            @include('guest.components.partials.school-details-abbreviated', [ 'school' => $school ])
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">No schools found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            <p class="is-size-7"><i>cc - community college, hbcu -, tech - technical, med - medical, rel - religious, sem - seminary</i></p>

            @if (!empty($pagination_bottom))
                {!! $schools->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
