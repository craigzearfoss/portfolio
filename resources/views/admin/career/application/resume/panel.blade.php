@php
    $applicationId = $applicationId ?? null;
    $resume        = $resume ?? null;
@endphp
<div class="card p-2 m-0" style="display: inline-block; flex-grow: 0;">

    <table>
        <tr>
            <tbody>
            <th>resume:</th>
            <td>
                {{ !empty($resume->date) ? longDate($resume->date) : '' }}
            </td>

            @if(empty($resume))
                <td>
                    @include('admin.components.link', [
                        'name'   => 'Attach a Resume',
                        'href'   => route(
                                        'admin.career.resume.create',
                                        !empty($applicationId) ? ['application_id' => $applicationId] : []
                                    ),
                        'class'  => 'button is-primary is-small px-1 py-0'
                    ])
                </td>

            @else

                <td>

                    <a title="show" class="button is-small px-1 py-0"
                       href="{{ route('admin.career.resume.show', $resume) }}">
                        <i class="fa-solid fa-list"></i>{{-- show --}}
                    </a>

                    <a title="edit" class="button is-small px-1 py-0"
                       href="{{ route('admin.career.resume.edit',$resume->id) }}">
                        <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                    </a>

                    @if(!empty($resume->url))

                        <a title="{{ !empty($resume->url) ? $resume->url : 'link' }}"
                           class="button is-small px-1 py-0"
                           href="{{ $resume->url }}"
                           target="_blank">
                            <i class="fa-solid fa-external-link"></i>{{-- link --}}
                        </a>
                    @endif

                </td>

            @endif

            </tbody>
        </tr>
    </table>

</div>
