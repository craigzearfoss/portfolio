@php
    $contacts = $contacts ?? [];
@endphp

@include('admin.components.search-panel.career-recruiter')

<div>

    <div class="show-container card floating-div p-4">

        @include('admin.components.export-buttons-container', [
            'href'     => route('admin.career.recruiter.export', request()->except([ 'page' ])),
            'filename' => 'recruiters_' . date("Y-m-d-His") . '.xlsx',
        ])

        <p><i>{{ number_format($recruiters->total()) }} {{ ($recruiters->total() === 1) ? 'recruiter' : 'recruiters' }} found.</i></p>

        @if (!empty($pagination_top))
            {!! $recruiters->links('vendor.pagination.bulma') !!}
        @endif

        <?php /* <p class="admin-table-caption"></p> */ ?>

        <table class="table admin-table {{ $adminTableClasses ?? '' }}">

            @php
                $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
            @endphp

            @foreach ($labelElems as $labelElem)

                <{{ $labelElem }}>
                <tr>
                    @if ($isRootAdmin)
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'id',
                                'sort'  => 'id|asc',
                            ])
                        </th>
                    @endif
                    <th>
                        @include('guest.components.column-heading', [
                            'class' => $className,
                            'name'  => 'name',
                            'sort'  => 'name|asc',
                        ])
                    </th>
                    <th style="white-space: nowrap;">coverage area</th>
                    <th>location</th>
                    <th>actions</th>
                </tr>
                </{{ $labelElem }}>

            @endforeach

            <tbody>

            @forelse ($recruiters as $recruiter)

                <tr data-id="{{ $recruiter->id }}">
                    @if ($isRootAdmin)
                        <td data-field="id">
                            {{ $recruiter->id }}
                        </td>
                    @endif
                    <td data-field="name" style="white-space: nowrap;">
                        @include('admin.components.link', [
                            'name' => $recruiter->name . (!empty($recruiter->featured) ? '<span class="featured-splat">*</span>' : ''),
                            'href' => route('admin.career.recruiter.show', $recruiter)
                        ])
                    </td>
                    <td data-field="international|national|regional|local" style="white-space: nowrap;">
                        {{ implode(', ', $recruiter->coverageAreas ?? []) }}
                    </td>
                    <td data-field="location" style="white-space: nowrap;">
                        {{
                            formatLocation([
                                'city'    => htmlspecialchars($recruiter->city),
                                'state'   => $recruiter->state->code ?? '',
                            ])
                        }}
                    </td>
                    <td data-field="is_disabled" class="has-text-centered" style="display: none;">
                        @include('admin.components.checkmark', [ 'checked' => $recruiter->is_public ])
                    </td>
                    <td data-field="is_disabled" class="has-text-centered" style="display: none;">
                        @include('admin.components.checkmark', [ 'checked' => $recruiter->is_disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if (canRead($recruiter, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.career.recruiter.show', $recruiter),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if (canUpdate($recruiter, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.career.recruiter.edit', $recruiter),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($recruiter->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($recruiter->link_name) ? $recruiter->link_name : 'link',
                                    'href'   => $recruiter->link,
                                    'icon'   => 'fa-external-link',
                                    'target' => '_blank'
                                ])
                            @else
                                @include('admin.components.link-icon', [
                                    'title'    => 'link',
                                    'icon'     => 'fa-external-link',
                                    'disabled' => true
                                ])
                            @endif

                            @if (canDelete($recruiter, $admin))
                                <form class="delete-resource" action="{!! route('admin.career.recruiter.destroy', $recruiter) !!}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    @include('admin.components.button-icon', [
                                        'title' => 'delete',
                                        'class' => 'delete-btn',
                                        'icon'  => 'fa-trash'
                                    ])
                                </form>
                            @endif

                        </div>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ $isRootAdmin ? '7' : '6' }}">No recruiters found.</td>
                </tr>

            @endforelse

            </tbody>

        </table>

        @if (!empty($pagination_bottom))
            {!! $recruiters->links('vendor.pagination.bulma') !!}
        @endif

    </div>

</div>
