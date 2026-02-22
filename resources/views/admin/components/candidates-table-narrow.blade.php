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
                <p class="is-size-7">{{ $candidate->employer ?? '' }}</p>
                <p class="is-size-7">{{ $candidate->role ?? '' }}</p>
            </td>
        </tr>

    @empty

        <tr>
            <td colspan="3">There are no candidates.</td>
        </tr>

    @endforelse

    </tbody>
</table>

{!! $candidates->links('vendor.pagination.bulma') !!}
