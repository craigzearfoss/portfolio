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
    <th>actions</th>
    </thead>
    <tbody>

    @foreach($coworkers as $coworker)

        <tr>
            <td>
                @include('admin.components.link', [
                    'name' => htmlspecialchars($coworker->name ?? ''),
                    'href' => route('admin.portfolio.job-coworker.show', $coworker)
                ])
            </td>
            <td data-field="featured" class="has-text-centered">
                {{ htmlspecialchars($coworker['title'] ?? '') }}
            </td>
            <td>
                {{ $coworker->level ?? '' }}
            </td>
            <td>
                {{ htmlspecialchars($coworker->phone ?? '') }}
            </td>
            <td>
                {{ htmlspecialchars($coworker->email ?? '') }}
            </td>
            <td class="is-1" style="white-space: nowrap;">

                <a title="show" class="button is-small px-1 py-0"
                       href="{{ route('admin.portfolio.job-coworker.show', $coworker) }}">
                    <i class="fa-solid fa-list"></i>{{-- show --}}
                </a>

                <a title="edit" class="button is-small px-1 py-0"
                   href="{{ route('admin.portfolio.job-coworker.edit', $coworker) }}">
                    <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                </a>

                @if (!empty($coworker->link))
                    <a title="{{ htmlspecialchars((!empty($coworker->link_name) ? $coworker->link_name : 'link' ?? '') }}"
                       class="button is-small px-1 py-0"
                       href="{{ $coworker->link }}"
                       target="_blank"
                    >
                        <i class="fa-solid fa-external-link"></i>{{-- link --}}
                    </a>
                @else
                    <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                        <i class="fa-solid fa-external-link"></i>{{-- link --}}
                    </a>
                @endif

            </td>
        </tr>

    @endforeach

    </tbody>
</table>
