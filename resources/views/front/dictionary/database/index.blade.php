@extends('front.layouts.default', [
    'title' => 'Dictionary Databases',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'url' => route('front.dictionary.index') ],
        [ 'name' => 'Databases' ]
    ],
    'buttons' => [],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>abbrev</th>
                <th class="text-center">sequence</th>
                <th class="text-center">public</th>
                <th class="text-center">read-only</th>
                <th class="text-center">root</th>
                <th class="text-center">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>abbrev</th>
                <th class="text-center">sequence</th>
                <th class="text-center">public</th>
                <th class="text-center">read-only</th>
                <th class="text-center">root</th>
                <th class="text-center">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($databases as $database)

                <tr>
                    <td class="py-0">
                        {{ $database->name }}
                    </td>
                    <td class="py-0">
                        {{ $database->abbreviation }}
                    </td>
                    <td class="py-0 text-center">
                        {{ $database->sequence }}
                    </td>
                    <td class="py-0 text-center">
                        @include('front.components.checkmark', [ 'checked' => $database->professional ])
                    </td>
                    <td class="py-0 text-center">
                        @include('front.components.checkmark', [ 'checked' => $database->personal ])
                    </td>
                    <td class="py-0 text-center">
                        @include('front.components.checkmark', [ 'checked' => $database->public ])
                    </td>
                    <td class="py-0 text-center">
                        @include('front.components.checkmark', [ 'checked' => $database->readonly ])
                    </td>
                    <td class="white-space-nowrap py-0" style="white-space: nowrap;">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('front.dictionary.database.show', $database->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        @if (!empty($database->link))
                            <a title="link" class="button is-small px-1 py-0" href="{{ $database->link }}"
                               target="_blank">
                                <i class="fa-solid fa-external-link"></i>{{-- link--}}
                            </a>
                        @else
                            <a title="link" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid fa-external-link"></i>{{-- link--}}
                            </a>
                        @endif

                        @if (!empty($database->wikipedia))
                            <a title="Wikipedia page" class="button is-small px-1 py-0" href="{{ $database->wikipedia }}"
                               target="_blank">
                                <i class="fa-solid fa-wikipedia-w"></i>{{-- wikipedia--}}
                            </a>
                        @else
                            <a title="Wikipedia page" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid fa-wikipedia-w"></i>{{-- wikipedia--}}
                            </a>
                        @endif

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="8">There are no databases.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $databases->links('vendor.pagination.bulma') !!}

    </div>

@endsection
