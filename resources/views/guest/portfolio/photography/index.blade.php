@extends('guest.layouts.default', [
    'title'         => $title ?? $admin->name . ' photography',
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.admin.portfolio.show', $admin) ],
        [ 'name' => 'Photography' ],
    ],
    'buttons'       => [],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>year</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>year</th>
            </tr>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($photos as $photo)

                <tr>
                    <td>
                        @include('guest.components.link', [
                            'name'  => $photo->name,
                            'href'  => route('guest.admin.portfolio.photography.show', [$admin, $photo->slug]),
                            'class' => $photo->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td class="has-text-centered">
                        {{ $photo->year }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="2">There are no photos.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $photos->links('vendor.pagination.bulma') !!}

    </div>

@endsection
