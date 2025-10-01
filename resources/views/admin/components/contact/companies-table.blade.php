@php
$notes = $notes ?? [];
@endphp
<table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
    <thead>
    <th>name</th>
    <th>active</th>
    <th>industry</th>
    <th>location</th>
    <th>phone</th>
    <th>email</th>
    </thead>
    <tbody>

    @foreach($companies as $company)

        <tr>
            <td>
                @include('admin.components.link', [
                    'name' => $company->name,
                    'href' => route('admin.career.company.show', $company)
                ])
            </td>
            <td data-field="featured" class="has-text-centered">
                @include('admin.components.checkmark', [ 'checked' => $company->pivot->active ])
            </td>
            <td data-field="industry.name">
                {{ $company->industry['name'] ?? '' }}
            </td>
            <td data-field="location" style="white-space: nowrap;">
                {!!
                    formatLocation([
                        'city'    => $company->city ?? null,
                        'state'   => $company->state['code'] ?? null,
                    ])
                !!}
            </td>
            <td>
                {{ $company->phone ?? '' }}
            </td>
            <td>
                {{ $company->email ?? '' }}
            </td>
        </tr>

    @endforeach

    </tbody>
</table>
