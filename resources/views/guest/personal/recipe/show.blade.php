@php
    $title    = $pageTitle ?? 'Recipe: ' . $recipe->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Personal',   'href' => route('guest.personal.index', $owner) ],
        [ 'name' => 'Recipes',    'href' => route('guest.personal.recipe.index', $owner) ],
        [ 'name' => $recipe->name ],
    ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.personal.recipe.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $recipe->disclaimer ])

    <div class="floating-div-container" style="display: inline-block;">

        <div class="show-container floating-div card" style="max-width: 40rem;">

            @include('guest.components.show-row', [
                'name'  => 'name',
                'value' => $recipe->name
            ])

            <?php /*
            @include('guest.components.show-row-checkbox', [
                'name'    => 'featured',
                'checked' => $recipe->featured
            ])
            */ ?>

            @if(!empty($recipe->summary))
                @include('guest.components.show-row', [
                    'name'  => 'summary',
                    'value' => $recipe->summary
                ])
            @endif

            @if(!empty($recipe->source))
                @include('guest.components.show-row', [
                    'name'  => 'source',
                    'value' => $recipe->source
                ])
            @endif

            @if(!empty($recipe->author))
                @include('guest.components.show-row', [
                    'name'  => 'author',
                    'value' => $recipe->author
                ])
            @endif

            @if(!empty($recipe->prep_time))
                @include('guest.components.show-row', [
                    'name'  => 'prep time',
                    'value' => $recipe->prep_time . ' minutes'
                ])
            @endif

            @if(!empty($recipe->total_time))
                @include('guest.components.show-row', [
                    'name'  => 'total time',
                    'value' => $recipe->total_time . ' minutes'
                ])
            @endif

            @php
            $types = $recipe->types();
            @endphp
            @if(!empty($types))
                @include('guest.components.show-row', [
                    'name'  => 'type',
                    'value' => implode(', ', $types)
                ])
            @endif

            @php
                $meals = $recipe->meals();
            @endphp
            @if(!empty($meals))
                @include('guest.components.show-row', [
                    'name'  => 'meal',
                    'value' => implode(', ', $meals)
                ])
            @endif

            @if(!empty($recipe->link))
                @include('guest.components.show-row-link', [
                    'name'   => !empty($recipe->link_name) ? $recipe->link_name : 'link',
                    'href'   => $recipe->link,
                    'target' => '_blank'
                ])
            @endif

            @if(!empty($recipe->description ))
                @include('guest.components.show-row', [
                    'name'  => 'description',
                    'value' => nl2br($recipe->description)
                ])
            @endif

            @if(!empty($recipe->image))
                @include('guest.components.show-row-image', [
                    'name'         => 'image',
                    'src'          => $recipe->image,
                    'alt'          => $recipe->name,
                    'width'        => '300px',
                    'download'     => true,
                    'external'     => true,
                    'filename'     => getFileSlug($recipe->name, $recipe->image),
                    'image_credit' => $recipe->image_credit,
                    'image_source' => $recipe->image_source,
                ])
            @endif

            @if(!empty($recipe->thumbnail))
                @include('guest.components.show-row-image', [
                    'name'     => 'thumbnail',
                    'src'      => $recipe->thumbnail . ' thumbnail',
                    'alt'      => $recipe->name,
                    'width'    => '40px',
                    'download' => true,
                    'external' => true,
                    'filename' => getFileSlug($recipe->name . '-thumbnail', $recipe->thumbnail)
                ])
            @endif

        </div>

        <div class="show-container floating-div card" style="max-width: 40rem;">

            <h2 class="subtitle mb-1">
                Ingredients
            </h2>
            <hr class="ml-0 mr-0 mt-1 mb-1">
            <ul>

                @foreach($recipe->ingredients as $ingredient)

                    <li class="ml-4">
                        {!! $ingredient->amount !!}
                        {!! \App\Models\Personal\Unit::find($ingredient->unit_id)->name !!}
                        {!! \App\Models\Personal\Ingredient::find($ingredient->ingredient_id)->name !!}
                        @if(!empty($ingredient->qualifier))
                            - {!! $ingredient->qualifier !!}
                        @endif
                    </li>

                @endforeach

            </ul>


        </div>
    </div>

    <div class="floating-div-container">

        <div class="show-container card floating-div" style="max-width: 80rem;">

            <h2 class="subtitle mb-1">
                Instructions
            </h2>
            <hr class="ml-0 mr-0 mt-1 mb-1">
            <table class="table guest-table {{ $guestTableClasses ?? '' }}">
                <tbody>

                @foreach($recipe->steps as $step)

                    <tr>
                        <td>
                            {!! $step->step !!}
                        </td>
                        <td>
                            {!! nl2br($step->description) !!}
                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>

        </div>

    </div>

@endsection
