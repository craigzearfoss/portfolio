@extends('guest.layouts.default', [
    'title' => $title ?? 'Recipe: ' . $recipe->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Personal',   'href' => route('guest.admin.personal.show', $admin) ],
        [ 'name' => 'Recipes',    'href' => route('guest.admin.personal.recipe.index', $admin) ],
        [ 'name' => $recipe->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.admin.personal.recipe.index', $admin) ],
    ],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

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
                'name'   => $recipe->link_name ?? 'link',
                'href'   => $recipe->link,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($recipe->description ))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => $recipe->description
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
