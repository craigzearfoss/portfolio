<div class="card p-4">

    <table class="table admin-table {{ $adminTableClasses ?? '' }}">
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
                        @include('admin.components.link', [
                            'name' => view('admin.components.image', [
                                            'src'      => $candidate->thumbnail,
                                            'alt'      => 'profile image',
                                            'width'    => '40px',
                                            'filename' => $candidate->thumbnail
                                        ]),
                            'href' => route('admin.system.admin.profile', $candidate),
                        ])
                    @endif
                </td>
                <td data-field="name">
                    @include('admin.components.link', [
                        'name' => !empty($candidate->name) ? $candidate->name : $candidate->label,
                        'href' => route('admin.system.admin.profile', $candidate),
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
