@extends('front.layouts.default', [
    'title' => 'Dictionary Libraries',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'url' => route('front.dictionary.index') ],
        [ 'name' => 'Libraries' ]
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

            @forelse ($libraries as $library)

                <tr>
                    <td class="py-0">
                        {{ $library->name }}
                    </td>
                    <td class="py-0">
                        {{ $library->abbreviation }}
                    </td>
                    <td class="py-0 text-center">
                        {{ $library->sequence }}
                    </td>
                    <td class="py-0 text-center">
                        @include('front.components.checkmark', [ 'checked' => $library->professional ])
                    </td>
                    <td class="py-0 text-center">
                        @include('front.components.checkmark', [ 'checked' => $library->personal ])
                    </td>
                    <td class="py-0 text-center">
                        @include('front.components.checkmark', [ 'checked' => $library->public ])
                    </td>
                    <td class="py-0 text-center">
                        @include('front.components.checkmark', [ 'checked' => $library->readonly ])
                    </td>
                    <td class="white-space-nowrap py-0" style="white-space: nowrap;">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('front.dictionary.library.show', $library->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        @if (!empty($library->link))
                            <a title="link" class="button is-small px-1 py-0" href="{{ $library->link }}"
                               target="_blank">
                                <i class="fa-solid fa-external-link"></i>{{-- link--}}
                            </a>
                        @else
                            <a title="link" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid fa-external-link"></i>{{-- link--}}
                            </a>
                        @endif

                        @if (!empty($library->wikipedia))
                            <a title="Wikipedia page" class="button is-small px-1 py-0" href="{{ $library->wikipedia }}"
                               target="_blank">
                                <i class="fa-solid wikipedia_w"></i>{{-- wikipedia--}}
                            </a>
                        @else
                            <a title="Wikipedia page" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid wikipedia_w"></i>{{-- wikipedia--}}
                            </a>
                        @endif

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="8">There are no libraries.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $libraries->links('vendor.pagination.bulma') !!}

    </div>

@endsection
