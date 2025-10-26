@extends('guest.layouts.default', [
    'title' => $title ?? $admin->name . ' recipes',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.index', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.admin.portfolio.index', $admin) ],
        [ 'name' => 'Recipes' ],
    ],
    'buttons' => [],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>type</th>
                <th>meal</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>type</th>
                <th>meal</th>
            </tr>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($recipes as $recipe)

                <tr>
                    <td>
                        @include('guest.components.link', [
                            'name'  => $recipe->name,
                            'href'  => route('guest.admin.personal.recipe.show', [$admin, $recipe->slug]),
                            'class' => $recipe->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td data-field="types">
                        {{ implode(', ', $recipe->types()) }}
                    </td>
                    <td data-field="meals">
                        {{ implode(', ', $recipe->meals()) }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="3">There are no recipes.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $recipes->links('vendor.pagination.bulma') !!}

    </div>

@endsection
