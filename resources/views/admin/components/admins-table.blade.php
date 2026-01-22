<div class="card p-4">

    <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
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
                <th style="white-space: nowrap;">user name</th>
                <th>name</th>
                <th>team</th>
                <th>email</th>
                <th>status</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
        <tbody>

        @forelse ($owners as $owner)

            <tr data-id="{{ $owner->id }}">
                <td data-field="thumbnail" style="width: 32px;">
                    @if(!empty($owner->thumbnail))
                        @include('admin.components.link', [
                            'name' => view('admin.components.image', [
                                            'src'      => $owner->thumbnail,
                                            'alt'      => 'profile image',
                                            'width'    => '30px',
                                            'filename' => $owner->thumbnail
                                        ]),
                            'href' => route('admin.system.admin.show', $owner),
                        ])
                    @endif
                </td>
                <td data-field="name">
                    @include('admin.components.link', [
                        'name' => !empty($owner->name) ? $owner->name : $owner->label,
                        'href' => route('admin.system.admin.show', $owner),
                    ])
                </td>
                <td data-field="role">
                    {{ $owner->role ?? '' }}
                </td>
                <td data-field="employer">
                    {{ $owner->employer ?? '' }}
                </td>
            </tr>

        @empty

            <tr>
                <td colspan="4">There are no users.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $owners->links('vendor.pagination.bulma') !!}

</div>
