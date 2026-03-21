@php
    $numCandidates = 8;
@endphp

@if(!empty($candidates) && $pagination_top)
    {!! $candidates->links('vendor.pagination.bulma') !!}
@endif

<table class="table user-table is-size-6 {{ $userTableClasses ?? '' }}">

    @if($top_column_headings)
        <thead>
        <tr>
            <th></th>
            <th>name</th>
            <th>employer / role</th>
        </tr>
        </thead>
    @endif

    @if($bottom_column_headings)
        <tfoot>
        <tr>
            <th></th>
            <th>name</th>
            <th>employer / role</th>
        </tr>
        </tfoot>
    @endif

    <tbody>

    @forelse ($candidates as $candidate)

        <tr data-id="{{ $candidate->id }}">
            <td data-field="thumbnail" style="width: 6rem;">
                @if(!empty($candidate->thumbnail))
                    @include('user.components.link', [
                        'name' => view('user.components.image', [
                                        'src'      => $candidate->thumbnail,
                                        'alt'      => 'profile image',
                                        'width'    => '40px',
                                        'filename' => $candidate->thumbnail
                                    ]),
                        'href' => route('user.system.admin.show', $candidate),
                    ])
                @endif
            </td>
            <td data-field="name">
                @include('user.components.link', [
                    'name' => !empty($candidate->name) ? $candidate->name : $candidate->label,
                    'href' => route('user.system.admin.show', $candidate),
                ])
            </td>
            <td data-field="role">
                <p class="is-size-7">{{ $candidate->employer ?? '' }}</p>
                <p class="is-size-7">{{ $candidate->role ?? '' }}</p>
            </td>
        </tr>

        @php if ($i >= $numCandidates - 1) break; @endphp
    @empty

        <tr>
            <td colspan="3">There are no candidates.</td>
        </tr>

    @endforelse

    </tbody>
</table>

@if(!empty($candidates) && $pagination_bottom)
    {!! $candidates->links('vendor.pagination.bulma') !!}
@endif
