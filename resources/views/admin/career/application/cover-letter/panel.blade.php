@php
    $applicationId = $applicationId ?? null;
    $coverLetter   = $coverLetter ?? null;
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-1">

        Cover Letter

        <span style="display: inline-flex; float: right;">

            @if(empty($coverLetter))

                @include('admin.components.link', [
                    'name'   => 'Attach a Cover Letter',
                    'href'   => route(
                                    'admin.career.cover-letter.create',
                                    !empty($applicationId) ? ['application_id' => $applicationId] : []
                                ),
                    'class'  => 'button is-primary is-small px-1 py-0'
                ])

            @else

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

            @endif

        </span>

    </h3>

    <hr class="navbar-divider">

    @if(!empty($coverLetter))

        @include('admin.components.show-row-link', [
            'name'  => 'date',
            'value' => longDate($coverLetter->date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'content',
            'value' => $coverLetter->content
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'url',
            'href'   => $coverLetter->url,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br(htmlspecialchars($coverLetter->notes))
        ])

        @include('admin.components.show-row-link', [
            'name'   => $coverLetter->link_name ?? 'link',
            'href'   => $coverLetter->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($coverLetter->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $coverLetter->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $coverLetter,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $coverLetter,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($coverLetter->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($coverLetter->updated_at)
        ])

    @endif

</div>
