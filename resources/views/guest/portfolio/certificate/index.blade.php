@extends('guest.layouts.default', [
    'title' => $title ?? $admin->name . ' certificates',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.admin.portfolio.show', $admin) ],
        [ 'name' => 'Certificates' ],
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

            @forelse ($certificates as $certificate)

                <tr>
                    <td>
                        @include('guest.components.link', [
                            'name'  => $certificate->name,
                            'href'  => route('guest.admin.portfolio.certificate.show', [$certificate->owner->username, $certificate->slug]),
                            'class' => $certificate->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td>
                        @if(!empty($certificate->academy['link']))
                            {{ $certificate->academy['name'] }}
                        @else
                            @include('guest.components.link', [
                                'name'   => $certificate->academy['name'],
                                'href'   => $certificate->academy['link'],
                                'target' => '_blank',
                            ])
                        @endif
                    </td>
                    <td class="has-text-centered">
                        {{ $certificate->organization }}
                    </td>
                    <td class="has-text-centered">
                        {{ $certificate->year }}
                    </td>
                    <td class="has-text-centered">
                        {{ shortDate($certificate->received) }}
                    </td>
                    <td class="has-text-centered">
                        {{ shortDate($certificate->expiration) }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="6">There are no certificates.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $certificates->links('vendor.pagination.bulma') !!}

    </div>

@endsection
