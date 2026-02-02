@php
    $applicationId = $applicationId ?? null;
    $resume        = $resume ?? null;
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">

        Resume

        <span style="display: inline-flex; float: right;">

            @if(empty($resume))
                @include('admin.components.link', [
                    'name'  => 'Attach a resume',
                    'href'  => route(
                                    'admin.career.resume.create',
                                    !empty($applicationId) ? ['application_id' => $applicationId] : []
                                ),
                    'class' => 'button is-primary is-small px-1 py-0'
                ])
            @else
                <?php //@TODO: Need to allow them to change the resume. ?>
            @endif

        </span>

    </h3>

    <hr class="navbar-divider">
    <div style="height: 12px; margin: 0; padding: 0;"></div>

    @if (!empty($resume))

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $resume->name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'date',
            'value' => longDate($resume->date),
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'Word doc',
            'label'  => !empty($resume->doc_url) ? '<i class="fa-solid fa-download"></i>download' : '',
            'href'   => !empty($resume->doc_url) ? route('download-from-public', [ 'file' => $resume->doc_url, 'name' => $resume->slug ]) : null,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'PDF doc',
            'label'  => !empty($resume->pdf_url) ? '<i class="fa-solid fa-download"></i>download' : '',
            'href'   => !empty($resume->pdf_url) ? route('download-from-public', [ 'file' => $resume->pdf_url, 'name' => $resume->slug ]) : null,
            'target' => '_blank'
        ])

        @if (!empty($resume->description))
            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $resume->description
            ])
        @endif

        @if (!empty($resume->content))
            @include('admin.components.show-row', [
                'name'  => 'content',
                'value' => $resume->content
            ])
        @endif

    @else

        <div class="has-text-centered">

            <i>No resume selected.</i>

        </div>

    @endif

</div>
