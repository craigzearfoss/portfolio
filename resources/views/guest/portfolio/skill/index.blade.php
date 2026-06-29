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

    @if ($owner->is_demo)
        @if ($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
        @endif
    @endif

    @include('guest.components.search-panel.portfolio-skill', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div" style="min-width: 30rem; max-width: 50rem; overflow-x: auto; overflow-y: hidden;">

            <p><i>{{ number_format($skills->total()) }} {{ ($skills->total() === 1) ? 'skill' : 'skills' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $skills->links('vendor.pagination.bulma') !!}
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
                        <th class="hide-at-600">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'category',
                                'sort'  => 'dictionary_category_name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'level',
                                'sort'  => 'level|desc',
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

                    <tr data-id="{{ $skill->id }}" {{ $skill->is_disabled ? 'class="disabled-text"' : '' }}>
                        <td style="white-space: nowrap;">
                            @if ($skill->featured)
                                <strong>{{ $skill->name }}</strong>
                            @else
                                {{ $skill->name }}
                            @endif
                            <?php /*
                            @include('guest.components.link-icon', [
                                'title'      => 'add to favorites',
                                'icon'       => 'fa-heart',
                                'border'     => false,
                                'target'     => '_blank',
                                'class'      => 'add-to-favorites',
                                'attributes' => [ 'data-resource' => 'portfolio.skill', 'data-id' => $skill->id ]
                            ])
                            */ ?>
                        </td>
                        <td class="hide-at-600" style="white-space: nowrap;">
                            {{ $skill->category->name ?? '' }}
                        </td>
                        <td data-field="level" style="white-space: nowrap;" class="font-size-12px-at-480 font-size-14px-at-600">
                            @if (!empty($skill->level))
                                @include('guest.components.star-ratings', [
                                    'rating' => $skill->level,
                                    'label'  => "({$skill->level})"
                                ])
                            @endif
                        </td>
                        <td class="has-text-centered hide-at-480">
                            {{ $skill->years }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">No skills found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $skills->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
