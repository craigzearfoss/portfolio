@php use Illuminate\Http\Request; @endphp
@extends('front.layouts.default', [
    'title' => 'Readings',
    'breadcrumbs' => [
        [ 'name' => 'Home', 'url' => route('front.homepage')],
        [ 'name' => 'Readings']
    ],
    'buttons' => [],
    'errors'  => $errors->any()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('front.components.form-select', [
            'name'     => '',
            'value'    => old('author') ?? '',
            'list'     => \App\Models\Portfolio\Reading::authorlistOptions(true),
            'onchange' => "alert('need to implement route.');",
            'message'  => $message ?? '',
        ])

        {!! $readings->links('vendor.pagination.bulma') !!}

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>title</th>
                <th>author</th>
                <th class="has-text-centered">type</th>
                <th class="has-text-centered">paper</th>
                <th class="has-text-centered">audio</th>
                <th class="text-center text-nowrap">wish list</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>title</th>
                <th>author</th>
                <th class="has-text-centered">type</th>
                <th class="has-text-centered">paper</th>
                <th class="has-text-centered">audio</th>
                <th class="text-center text-nowrap">wish list</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($readings as $reading)

                <tr>
                    <td>
                        @include('front.components.link', [
                            'name'   => $reading->name,
                            'url'    => route('front.reading.show', $reading->slug)
                        ])
                    </td>
                    <td>
                        {{ $reading->author }}
                    </td>
                    <td class="has-text-centered">
                        {{ $reading->fiction ? 'fiction' : ($reading->nonfiction ? 'nonfiction' : '') }}
                    </td>
                    <td class="has-text-centered">
                        @include('front.components.checkmark', [ 'checked' => $reading->paper ])
                    </td>
                    <td class="has-text-centered">
                        @include('front.components.checkmark', [ 'checked' => $reading->audio ])
                    </td>
                    <td class="has-text-centered">
                        @include('front.components.checkmark', [ 'checked' => $reading->wishlist ])
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="6">There are no readings.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $readings->links('vendor.pagination.bulma') !!}

    </div>

@endsection
