@php
    $applicationId = $applicationId ?? null;
    $coverLetter   = $coverLetter ?? null;
@endphp
<div class="card p-2 m-0" style="display: inline-block; flex-grow: 0;">

    <table>
        <tr>
            <tbody>
            <th>cover letter:</th>
            <td>
                {{ !empty($coverLetter->date) ? longDate($coverLetter->date) : '' }}
            </td>

            @if(empty($coverLetter))
                <td>
                    @include('admin.components.link', [
                        'name'   => 'Attach a Cover Letter',
                        'href'   => route(
                                        'admin.career.cover-letter.create',
                                        !empty($applicationId) ? ['application_id' => $applicationId] : []
                                    ),
                        'class'  => 'button is-primary is-small px-1 py-0'
                    ])
                </td>

            @else

                <td>

                    <a title="show" class="button is-small px-1 py-0"
                       href="{{ route('admin.career.cover-letter.show', $coverLetter) }}">
                        <i class="fa-solid fa-list"></i>{{-- show --}}
                    </a>

                    <a title="edit" class="button is-small px-1 py-0"
                       href="{{ route('admin.career.cover-letter.edit',$coverLetter->id) }}">
                        <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                    </a>

                    @if(!empty($coverLetter->url))

                        <a title="{{ !empty($coverLetter->url) ? $coverLetter->url : 'link' }}"
                           class="button is-small px-1 py-0"
                           href="{{ $coverLetter->url }}"
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
