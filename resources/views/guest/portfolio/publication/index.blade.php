@php @endphp
@extends('guest.layouts.default', [
    'title'         => $pageTitle ?? $currentAdmin->name . ' publications',
    'breadcrumbs'   => [
        [ 'name' => 'Home',              'href' => route('home') ],
        [ 'name' => 'Users',             'href' => route('home') ],
        [ 'name' => $currentAdmin->name, 'href' => route('guest.admin.show', $currentAdmin)],
        [ 'name' => 'Portfolio'       ,  'href' => route('guest.portfolio.index', $currentAdmin) ],
        [ 'name' => 'Publications' ],
    ],
    'buttons'       => [],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => $currentAdmin,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>title</th>
                <th>publication</th>
                <?php /* <th>publisher</th> */ ?>
                <th>year</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>title</th>
                <th>publication</th>
                <th>publisher</th>
                <th>year</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($publications as $publication)

                <tr data-id="{{ $publication->id }}">
                    <td data-field="title">
                        @include('guest.components.link', [
                            'name'  => $publication->title,
                            'href'  => route('guest.portfolio.publication.show', [$currentAdmin, $publication->slug]),
                            'class' => $publication->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td data-field="publication_name">
                        {!! $publication->publication_name !!}
                    </td>
                    <?php /*
                    <td data-field="publisher">
                        {!! $publication->publisher !!}
                    </td>
                    */ ?>
                    <td data-field="year" class="has-text-centered">
                        {!! $publication->year !!}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="3">There are no publications.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $publications->links('vendor.pagination.bulma') !!}

    </div>

@endsection
