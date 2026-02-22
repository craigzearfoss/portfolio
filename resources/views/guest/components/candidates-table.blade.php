<div class="card p-4">

    <table class="table guest-table {{ $guestTableClasses ?? '' }}">
        <thead>
        <tr>
            <th></th>
            <th>name</th>
            <th>role</th>
            <th>employer</th>
        </tr>
        </thead>
        <?php /*
            <tfoot>
            <tr>
                <th></th>
                <th>name</th>
                <th>role</th>
                <th>employer</th>
            </tr>
            </tfoot>
            */ ?>
        <tbody>

        @forelse ($candidates as $candidate)

            <tr data-id="{{ $candidate->id }}">
                <td data-field="thumbnail" style="width: 40px; padding: 1px;">
                    @if(!empty($candidate->thumbnail))
                        @include('guest.components.link', [
                            'name' => view('guest.components.image', [
                                            'src'      => $candidate->thumbnail,
                                            'alt'      => 'profile image',
                                            'width'    => '40px',
                                            'filename' => $candidate->thumbnail
                                        ]),
                            'href' => route('guest.admin.show', $candidate),
                        ])
                    @endif
                </td>
                <td data-field="name">
                    @include('guest.components.link', [
                        'name' => !empty($candidate->name) ? $candidate->name : $candidate->label,
                        'href' => route('guest.admin.show', $candidate),
                    ])
                </td>
                <td data-field="role">
                    {{ $candidate->role ?? '' }}
                </td>
                <td data-field="employer">
                    {{ $candidate->employer ?? '' }}
                </td>
            </tr>

        @empty

            <tr>
                <td colspan="4">There are no candidates.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $candidates->links('vendor.pagination.bulma') !!}

</div>
