@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $recipe           = $recipe ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('Recipe: ' . $recipe->name, $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
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

            <table>
                <tbody>

                @if(!empty($recipe->name))
                    <tr>
                        <th>name:</th>
                        <td>{{ $recipe->name }}</td>
                    </tr>
                @endif

                @if(!empty($recipe->summary))
                    <tr>
                        <th>summary:</th>
                        <td>{!! $recipe->summary !!}</td>
                    </tr>
               @endif

                @if(!empty($recipe->source))
                    <tr>
                        <th>source:</th>
                        <td>{{ $recipe->source }}</td>
                    </tr>
               @endif

                @if(!empty($recipe->author))
                    <tr>
                        <th>author:</th>
                        <td>{{ $recipe->author }}</td>
                    </tr>
               @endif

                @if(!empty($recipe->prep_time))
                    <tr>
                        <th>prep time:</th>
                        <td>{{ $recipe->prep_time }} minutes</td>
                    </tr>
               @endif

                @if(!empty($recipe->total_time))
                    <tr>
                        <th>total time:</th>
                        <td>{{ $recipe->total_time }} minutes</td>
                    </tr>
                @endif

                @php
                    $types = $recipe->types();
                @endphp
                @if(!empty($types))

                @endif
                <tr>
                    <th>type:</th>
                    <td>{{ implode(', ', $types) }}</td>
                </tr>

                @php
                    $meals = $recipe->meals();
                @endphp
                @if(!empty($meals))
                    <tr>
                        <th>meal:</th>
                        <td>{{ implode(', ', $meals) }}</td>
                    </tr>
                @endif

                @if(!empty($recipe->link))
                    <tr>
                        <th>{{ !empty($recipe->link_name) ? $recipe->link_name : 'link' }}:</th>
                        <td>
                            @include('guest.components.link', [
                                'name'   => !empty($recipe->link_name) ? $recipe->link_name : 'link',
                                'href'   => $recipe->link,
                                'target' => '_blank'
                            ])
                        </td>
                    </tr>
                @endif

                @if(!empty($recipe->description))
                    <tr>
                        <th>description:</th>
                        <td>{!! $recipe->description !!}</td>
                    </tr>
                @endif

                @if(!empty($recipe->image))
                    <tr>
                        <td colspan="2">
                            @include('guest.components.image-credited', [
                                'name'         => 'image',
                                'src'          => $recipe->image,
                                'alt'          => $recipe->name,
                                'width'        => '300px',
                                'download'     => true,
                                'external'     => true,
                                'filename'     => generateDownloadFilename($recipe),
                                'image_credit' => $recipe->image_credit,
                                'image_source' => $recipe->image_source,
                            ])
                        </td>
                    </tr>
                @endif

                </tbody>
            </table>

        </div>

        <div class="show-container floating-div card" style="max-width: 30rem;">

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

        <div class="show-container card floating-div">

            <h2 class="subtitle mb-1">
                Instructions
            </h2>
            <hr class="ml-0 mr-0 mt-1 mb-1">
            <table class="table guest-table {{ $guestTableClasses ?? '' }}">
                <tbody>

                @foreach($recipe->steps as $step)

                    <tr>
                        <td style="width: 6px;">
                            {!! $step->step !!}
                        </td>
                        <td style="width: auto; max-width: 60rem;">
                            {!! $step->description !!}
                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>

        </div>

    </div>

@endsection
