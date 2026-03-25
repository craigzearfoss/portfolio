<div class="card p-4">

    @if(!empty($candidates) && $pagination_top)
        {!! $candidates->links('vendor.pagination.bulma') !!}
    @endif

    <table class="table admin-table {{ $adminTableClasses ?? '' }}">

        @if($top_column_headings)
            <thead>
            <tr>
                <th></th>
                <th>name</th>
                <th>role</th>
                <th>employer</th>
            </tr>
            </thead>
        @endif

        @if($bottom_column_headings)
            <tfoot>
            <tr>
                <th></th>
                <th>name</th>
                <th>role</th>
                <th>employer</th>
            </tr>
            </tfoot>
        @endif

        <tbody>

        @forelse ($candidates as $candidate)

            <tr data-id="{{ $candidate->id }}">
                <td data-field="thumbnail" style="width: 6rem;">
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
                <td colspan="4">No candidates found.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    @if(!empty($candidates) && $pagination_bottom)
        {!! $candidates->links('vendor.pagination.bulma') !!}
    @endif

</div>
