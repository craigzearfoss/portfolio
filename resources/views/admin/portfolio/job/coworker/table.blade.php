@php
$coworkers = $coworkers ?? [];
@endphp
<table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
    <thead>
    <th>name</th>
    <th style="min-width: 6em;">title</th>
    <th>level</th>
    <th>phone</th>
    <th>email</th>
    <th>Actions</th>
    </thead>
    <tbody>

    @foreach($coworkers as $coworker)

        <tr>
            <td>
                @include('admin.components.link', [
                    'name' => $coworker->name,
                    'href' => '', /*route('admin.portfolio.job-coworker.show', $coworker)*/
                ])
            </td>
            <td data-field="featured" class="has-text-centered">
                {{ $coworker['title'] ?? '' }}
            </td>
            <td>
                {{ $coworker->level ?? '' }}
            </td>
            <td>
                {{ $contact->phone ?? '' }}
            </td>
            <td>
                {{ $contact->email ?? '' }}
            </td>
            <td class="is-1" style="white-space: nowrap;">
                <?php /*
                <form action="{{ route('admin.career.company.contact.detach', [
                        $contact->pivot->company_id,
                        $contact->pivot->contact_id
                    ]) }}"
                      method="POST"
                >

                    <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.career.contact.show', $contact) }}">
                        <i class="fa-solid fa-list"></i>{{-- show --}}
                    </a>

                    @csrf
                    @method('DELETE')
                    <button title="remove" type="submit" class="button is-small px-1 py-0">
                        <i class="fa-solid fa-trash"></i>{{-- delete --}}
                    </button>
                </form>
                */ ?>
            </td>
        </tr>

    @endforeach

    </tbody>
</table>
