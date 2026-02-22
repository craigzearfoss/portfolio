<table class="table admin-table is-size-6 {{ $adminTableClasses ?? '' }}">
    <thead>
    <tr>
        <th></th>
        <th>name</th>
        <th>employer / role</th>
    </tr>
    </thead>
    <?php /*
        <tfoot>
        <tr>
            <th></th>
            <th>name</th>
            <th>employer / role</th>
        </tr>
        </tfoot>
        */ ?>
    <tbody>

    @forelse ($admins as $thisAdmin)

        <tr data-id="{{ $thisAdmin->id }}">
            <td data-field="thumbnail" style="width: 40px; padding: 1px;">
                @if(!empty($thisAdmin->thumbnail))
                    @include('admin.components.link', [
                        'name' => view('admin.components.image', [
                                        'src'      => $thisAdmin->thumbnail,
                                        'alt'      => 'profile image',
                                        'width'    => '40px',
                                        'filename' => $thisAdmin->thumbnail
                                    ]),
                        'href' => route('admin.system.admin.profile', $thisAdmin),
                    ])
                @endif
            </td>
            <td data-field="name">
                @include('admin.components.link', [
                    'name' => !empty($thisAdmin->name) ? $thisAdmin->name : $thisAdmin->label,
                    'href' => route('admin.system.admin.profile', $thisAdmin),
                ])
            </td>
            <td data-field="role">
                <p class="is-size-7">{{ $thisAdmin->employer ?? '' }}</p>
                <p class="is-size-7">{{ $thisAdmin->role ?? '' }}</p>
            </td>
        </tr>

    @empty

        <tr>
            <td colspan="3">There are no admins.</td>
        </tr>

    @endforelse

    </tbody>
</table>

{!! $admins->links('vendor.pagination.bulma') !!}
