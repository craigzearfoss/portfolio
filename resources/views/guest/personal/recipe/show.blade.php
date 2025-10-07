@extends('guest.layouts.default', [
    'title' => $title ?? 'Recipe: ' . $recipe->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',     'href' => route('guest.homepage') ],
        [ 'name' => 'Personal', 'href' => route('guest.personal.index') ],
        [ 'name' => 'Recipes',  'href' => route('guest.personal.recipe.index') ],
        [ 'name' => $recipe->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.personal.reading.index') ],
    ],
    'errors'  => $errors->any()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $recipe->name
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $recipe->featured
        ])

        @include('guest.components.show-row', [
            'name'  => 'summary',
            'value' => $recipe->summary
        ])

        @include('guest.components.show-row', [
            'name'  => 'source',
            'value' => $recipe->source
        ])

        @include('guest.components.show-row', [
            'name'  => 'author',
            'value' => $recipe->author
        ])

        @include('guest.components.show-row', [
            'name'  => 'prep time',
            'value' => !empty($recipe->prep_time) ? ($recipe->prep_time . ' minutes') : ''
        ])

        @include('guest.components.show-row', [
            'name'  => 'total time',
            'value' => !empty($recipe->total_time) ? ($recipe->total_time . ' minutes') : ''
        ])

        @include('guest.components.show-row', [
            'name'  => 'type',
            'value' => $recipe->type
        ])

        @include('guest.components.show-row', [
            'name'  => 'meal',
            'value' => $recipe->meal
        ])

        @include('guest.components.show-row', [
            'name'  => 'notes',
            'value' => $recipe->notes
        ])

        @if(!empty($recipe->link))
            @include('guest.components.show-row-link', [
                'name'   => 'link',
                'label'  => $recipe->link_name,
                'href'   => $recipe->link,
                'target' => '_blank'
            ])
        @endif

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($recipe->description ?? '')
        ])

        @if(!empty($recipe->image))

            @include('guest.components.show-row-image', [
                'name'     => 'image',
                'src'      => $recipe->image,
                'alt'      => $recipe->name . ', ' . $recipe->artist,
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($recipe->name . '-by-' . $recipe->artist, $recipe->image)
            ])

            @if(!empty($recipe->image_credit))
                @include('guest.components.show-row', [
                    'name'  => 'image credit',
                    'value' => $recipe->image_credit
                ])
            @endif

            @if(!empty($recipe->image_source))
                @include('guest.components.show-row', [
                    'name'  => 'image source',
                    'value' => $recipe->image_source
                ])
            @endif

        @endif

        @if(!empty($recipe->thumbnail))

            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $recipe->thumbnail,
                'alt'      => $recipe->name . ', ' . $recipe->artist,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($recipe->name . '-by-' . $recipe->artist, $recipe->thumbnail)
            ])

        @endif

    </div>

    <div class="card p-4">

        <h2 class="subtitle">
            Ingredients
        </h2>
        <ul>

            @foreach($recipe->ingredients as $ingredient)

                <li>
                    {{ $ingredient['amount'] }}
                    {{ \App\Models\Personal\Unit::find($ingredient['unit_id'])->name }}
                    {{ \App\Models\Personal\Ingredient::find($ingredient['ingredient_id'])->name }}
                    @if(!empty($ingredient['qualifier']))
                        - {{ $ingredient['qualifier'] }}
                    @endif
                </li>

            @endforeach

        </ul>

    </div>

    <div class="card p-4">

        <h2 class="subtitle">
            Instructions
        </h2>
        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <tbody>

            @foreach($recipe->steps as $step)

                <tr>
                    <td>
                        {{ $step['step'] }}
                    </td>
                    <td>
                        {{ $step['description'] }}
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>

    </div>

@endsection
