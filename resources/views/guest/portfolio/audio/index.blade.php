@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\Audio';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('audio', $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Audio' ],
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

    @include('guest.components.search-panel.portfolio-audio', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            <p><i>{{ number_format($audios->total()) }} {{ ($audios->total() === 1) ? 'audio' : 'audios' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $audios->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}" style="min-width: 30rem; max-width: 50rem; overflow-x: auto; overflow-y: hidden;">

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
                            type
                        </th>
                        <th class="has-text-centered hide-at-480">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'year',
                                'sort'  => 'audio_year|asc',
                            ])
                        </th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($audios as $audio)

                    <tr data-id="{{ $audio->id }}" {{ $audio->is_disabled ? 'class="disabled-text"' : '' }}>
                        <td data-field="name" style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => $audio->name,
                                'href'  => route('guest.portfolio.audio.show', [$owner, $audio->slug]),
                                'class' => $audio->featured ? [ 'has-text-weight-bold' ] : []
                            ])
                            <?php /*
                            @include('guest.components.link-icon', [
                                'title'      => 'add to favorites',
                                'icon'       => 'fa-heart',
                                'border'     => false,
                                'target'     => '_blank',
                                'class'      => 'add-to-favorites',
                                'attributes' => [ 'data-resource' => 'portfolio.audio', 'data-id' => $audio->id ]
                            ])
                            */ ?>
                        </td>
                        <td data-field="clip|podcast" class="hide-at-600" style="white-space: nowrap;">
                            @php
                                $types = [];
                                if ($audio->podcast) $types[] = 'podcast';
                                if ($audio->clip) $types[] = 'clip';
                            @endphp
                            {{ implode(', ', $types) }}
                        </td>
                        <td data-field="year" class="has-text-centered hide-at-480">
                            {{ $audio->audio_year }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="3">No audio found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $audios->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
