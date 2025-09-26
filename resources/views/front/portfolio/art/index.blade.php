@extends('Front.layouts.default', [
    'title' => 'Art',
    'breadcrumbs' => [
        [ 'name' => 'Home',      'url' => route('front.index') ],
        [ 'name' => 'Portfolio', 'url' => route('front.portfolio.index') ],
        [ 'name' => 'Art' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Art', 'url' => route('front.portfolio.art.create') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>artist</th>
                <th>year</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">read-only</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>artist</th>
                <th>year</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">read-only</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($arts as $art)

                <tr>
                    <td class="py-0">
                        {{ $art->name }}
                    </td>
                    <td class="py-0 has-text-centered">
                        {{ $art->artist }}
                    </td>
                    <td class="py-0 has-text-centered">
                        {{ $art->year }}
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('front.components.checkmark', [ 'checked' => $art->public ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('front.components.checkmark', [ 'checked' => $art->readonly ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('front.components.checkmark', [ 'checked' => $art->root ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('front.components.checkmark', [ 'checked' => $art->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('front.portfolio.art.show', $art->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- show --}}
                        </a>

                        @if (!empty($art->link))
                            <a title="{{ !empty($art->link_name) ? $art->link_name : 'link' }}"
                               class="button is-small px-1 py-0"
                               href="{{ $art->link }}"
                               target="_blank"
                            >
                                <i class="fa-solid fa-external-link"></i>{{-- link --}}
                            </a>
                        @else
                            <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid fa-external-link"></i>{{-- link --}}
                            </a>
                        @endif

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="8">There is no art.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $arts->links('vendor.pagination.bulma') !!}

    </div>

@endsection

@extends('front.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('front.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('front.components.header')

                @include('front.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Art</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('front.components.messages', [$errors])
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th>name</th>
                            <th>featured</th>
                            <th>description</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($arts as $art)

                            <tr>
                                <td>
                                    @include('front.components.link', [
                                        'name'   => $art->name,
                                        'url'    => route('front.portfolio.art.show', $art->slug)
                                    ])
                                </td>
                                <td class="has-text-centered">
                                    @include('front.components.checkmark', [ 'checked' => $art->featured ])
                                </td>
                                <td>
                                    {!! nl2br($art->description ?? '') !!}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="5">There is no art.</td>
                            </tr>

                        @endforelse

                        </tbody>
                    </table>

                    {!! $arts->links() !!}

                    @include('front.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
