@php
$recruiters = $recruiters ?? [];
@endphp
<table class="table admin-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <tr>
        <th>name</th>
        <th>active</th>
        <th style="white-space: nowrap;">coverage area</th>
        <th>location</th>
        <th>phone</th>
        <th>email</th>
    </tr>
    </thead>
    <tbody>

    @foreach ($recruiters as $recruiter)

        <tr data-id="{{ $recruiter->id }}" {!! $recruiter->is_disabled ? 'class="disabled-text"' : '' !!}>
            <td data-field="name">
                @include('admin.components.link', [
                    'name'  => htmlspecialchars($recruiter->name),
                    'href'  => route('admin.career.recruiter.show', $recruiter),
                    'class' => $recruiter->is_disabled ? [ 'disabled-text' ] : []
                ])
            </td>
            <td data-field="international|national|regional|local">
                {{ implode(', ', $recruiter->coverageAreas ?? []) }}
            </td>
            <td data-field="location" style="white-space: nowrap;">
                {!!
                    formatLocation([
                        'city'    => htmlspecialchars($recruiter->city),
                        'state'   => $recruiter->state['code'] ?? null,
                    ])
                !!}
            </td>
            <td data-field="phone">
                {{ $recruiter->phone ?? '' }}
            </td>
            <td class="is-1" style="white-space: nowrap;">
                <form action="{{ route('admin.career.contact.recruiter.detach', [
                        $recruiter->pivot->contact_id,
                        $recruiter->pivot->recruiter_id
                    ]) }}"
                      method="POST"
                >

                    <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.career.recruiter.show', $recruiter) }}">
                        <i class="fa-solid fa-list"></i>
                    </a>

                    @csrf
                    @method('DELETE')
                    <button title="remove" type="submit" class="button is-small px-1 py-0">
                        <i class="fa-solid fa-trash"></i>{
                    </button>
                </form>
            </td>
        </tr>

    @endforeach

    </tbody>
</table>
