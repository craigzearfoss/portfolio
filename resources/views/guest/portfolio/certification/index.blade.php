@extends('guest.layouts.default', [
    'title' => $title ?? 'Certifications',
    'breadcrumbs' => [
        [ 'name' => 'Home',      'href' => route('guest.homepage') ],
        [ 'name' => 'Portfolio', 'href' => route('guest.portfolio.index') ],
        [ 'name' => 'Certifications' ],
    ],
    'buttons' => [],
    'errors'  => $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>academy</th>
                <th>organization</th>
                <th>year</th>
                <th>received</th>
                <th>expiration</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>academy</th>
                <th>organization</th>
                <th>year</th>
                <th>received</th>
                <th>expiration</th>
            </tr>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($certifications as $certification)

                <tr>
                    <td>
                        @include('guest.components.link', [
                            'name'  => $certification->name,
                            'href'  => route('guest.portfolio.certification.show', $certification->slug),
                            'class' => $certification->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td>
                        @if(!empty($certification->academy['link']))
                            {{ $certification->academy['name'] }}
                        @else
                            @include('guest.components.link', [
                                'name'   => $certification->academy['name'],
                                'href'   => $certification->academy['link'],
                                'target' => '_blank',
                            ])
                        @endif
                    </td>
                    <td class="has-text-centered">
                        {{ $certification->organization }}
                    </td>
                    <td class="has-text-centered">
                        {{ $certification->year }}
                    </td>
                    <td class="has-text-centered">
                        {{ shortDate($certification->received) }}
                    </td>
                    <td class="has-text-centered">
                        {{ shortDate($certification->expiration) }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="5">There are no certifications.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $certifications->links('vendor.pagination.bulma') !!}

    </div>

@endsection
