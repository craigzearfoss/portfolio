<div class="card p-4">

    <table class="table user-table {{ $userTableClasses ?? '' }}">
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

        @forelse ($admins as $thisAdmin)

            <tr data-id="{{ $thisAdmin->id }}">
                <td data-field="thumbnail" style="width: 40px; padding: 1px;">
                    @if(!empty($thisAdmin->thumbnail))
                        @include('user.components.link', [
                            'name' => view('user.components.image', [
                                            'src'      => $thisAdmin->thumbnail,
                                            'alt'      => 'profile image',
                                            'width'    => '40px',
                                            'filename' => $thisAdmin->thumbnail
                                        ]),
                            'href' => route('user.system.admin.show', $thisAdmin),
                        ])
                    @endif
                </td>
                <td data-field="name">
                    @include('user.components.link', [
                        'name' => !empty($thisAdmin->name) ? $thisAdmin->name : $thisAdmin->label,
                        'href' => route('user.system.admin.show', $thisAdmin),
                    ])
                </td>
                <td data-field="role">
                    {{ $thisAdmin->role ?? '' }}
                </td>
                <td data-field="employer">
                    {{ $thisAdmin->employer ?? '' }}
                </td>
            </tr>

        @empty

            <tr>
                <td colspan="4">There are no admins.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $admins->links('vendor.pagination.bulma') !!}

</div>
