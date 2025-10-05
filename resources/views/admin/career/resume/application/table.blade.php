@php
$notes = $notes ?? [];
@endphp
<table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
    <thead>
    <th>company</th>
    <th>role</th>
    <th>active</th>
    <th>post date</th>
    <th>apply data</th>
    <th>close date</th>
    </thead>
    <tbody>

    @foreach($applications as $application)

        <tr>
            <td>
                company
            </td>
            <td>
                {{ $application['role'] ?? '' }}
            </td>
            <td>
                @include('admin.components.checkmark', [ 'checked' => !empty($application['active']) ])
            </td>
            <td>
                {{ shortDateTime($application['post_date']) }}
            </td>
            <td>
                {{ shortDateTime($application['apply_date']) }}
            </td>
            <td>
                {{ shortDateTime($application['close_date']) }}
            </td>
        </tr>

    @endforeach

    </tbody>
</table>
