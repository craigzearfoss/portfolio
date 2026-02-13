@php
$notes = $notes ?? [];
@endphp
<table class="table admin-table">
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
                @include('admin.components.link', [
                    'name' => $application->company->name,
                    'href' => route('admin.career.company.show', $application->company)
                ])
            </td>
            <td>
                @include('admin.components.link', [
                    'name' => $application->role,
                    'href' => route('admin.career.application.show', $application)
                ])
            </td>
            <td>
                @include('admin.components.checkmark', [ 'checked' => !empty($application->active) ])
            </td>
            <td>
                {{ !empty($application->post_date) ? date("m/d/Y", strtotime($application->post_date)) : '' }}
            </td>
            <td>
                {{ !empty($application->apply_date) ? date("m/d/Y", strtotime($application->apply_date)) : '' }}
            </td>
            <td>
                {{ !empty($application->close_date) ? date("m/d/Y", strtotime($application->close_date)) : '' }}
            </td>
        </tr>

    @endforeach

    </tbody>
</table>
