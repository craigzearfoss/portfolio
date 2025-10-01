@php
$companies = $companies ?? [];
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
            <td class="is-1" style="white-space: nowrap;">
                <form action="{{ route('admin.career.contact.company.detach', [
                        $company->pivot->contact_id,
                        $company->pivot->company_id
                    ]) }}"
                      method="POST"
                >

                    <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.career.company.show', $company) }}">
                        <i class="fa-solid fa-list"></i>{{-- show --}}
                    </a>

                    @csrf
                    @method('DELETE')
                    <button title="remove" type="submit" class="button is-small px-1 py-0">
                        <i class="fa-solid fa-trash"></i>{{-- delete --}}
                    </button>
                </form>
            </td>
        </tr>

    @endforeach

    </tbody>
</table>
