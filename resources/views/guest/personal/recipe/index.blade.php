@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? $admin->name . ' recipes',
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('home') ],
        [ 'name' => 'Users',      'href' => route('home') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Personal',   'href' => route('guest.personal.index', $admin) ],
        [ 'name' => 'Recipes' ],
    ],
    'buttons'          => [],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
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
                            'href'  => route('guest.personal.recipe.show', [$admin, $recipe->slug]),
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
