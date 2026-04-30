@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\Skill';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

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

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'name',
                                'sort'  => 'name|asc',
                            ])
                        </th>
                        <th class="hide-at-600">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'category',
                                'sort'  => 'category|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'level',
                                'sort'  => 'level|asc',
                            ])
                        </th>
                        <th class="has-text-centered hide-at-480">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'years',
                                'sort'  => 'years|asc',
                            ])
                        </th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

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
