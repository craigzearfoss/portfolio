@php
    $title    = $pageTitle ?? filteredPageTitle('skills', $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Skills' ],
          ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @if($owner->is_demo)
        @if($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
        @endif
    @endif

    @include('guest.components.search-panel.portfolio-skill', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container" style="max-width: 80em !important;">

        <div class="show-container card floating-div">

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">
                <thead>
                <tr>
                    <th>name</th>
                    <th class="hide-at-600">category</th>
                    <th>level (out of 10)</th>
                    <th class="has-text-centered hide-at-480">years</th>
                </tr>
                </thead>
                <?php /*
                <tfoot>
                <tr>
                    <th>name</th>
                    <th class="hide-at-600">category</th>
                    <th>level (out of 10)</th>
                    <th class="has-text-centered hide-at-480">years</th>
                </tr>
                </tr>
                </tfoot>
                */ ?>
                <tbody>

                @forelse ($skills as $skill)

                    <tr>
                        <td>
                            @if($skill->featured)
                                <strong>{!! $skill->name !!}</strong>
                            @else
                                {!! $skill->name !!}
                            @endif
                        </td>
                        <td class="hide-at-600">
                            {!! $skill->category->name ?? '' !!}
                        </td>
                        <td data-field="level" style="white-space: nowrap;" class="font-size-12px-at-480 font-size-14px-at-600">
                            @if(!empty($skill->level))
                                @include('guest.components.star-ratings', [
                                    'rating' => $skill->level,
                                    'label'  => "({$skill->level})"
                                ])
                            @endif
                        </td>
                        <td class="has-text-centered hide-at-480">
                            {!! $skill->years !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">No skills found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            {!! $skills->links('vendor.pagination.bulma') !!}

        </div>

    </div>

@endsection
