@php
    use App\Models\Career\Resume;

    $applicationId = $applicationId ?? null;
    $resume        = $resume ?? null;
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">

        Resume

        <span style="display: inline-flex; float: right;">

            @if(!empty($resume))

                <a title="show" class="button is-small px-1 py-0"
                   href="{!! route('admin.career.resume.show', $resume) !!}">
                        <i class="fa-solid fa-list"></i>
                    </a>

                <a title="edit" class="button is-small px-1 py-0"
                   href="{!! route('admin.career.resume.edit',$resume->id) !!}">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>

                @if(!empty($resume->url))
                    @include('admin.components.button-download', [ 'file' => $resume->url,
                                                                   'name' =>$resume->slug . '-resume' ])
                @endif

                @include('admin.components.button-download', [ 'file' => '',
                                                                   'name' =>$resume->slug . '-resume' ])

            @endif

        </span>

    </h3>

    <hr class="navbar-divider">

    @if(empty($resume))

        <div class="has-text-centered" style="max-width: 30rem;">

            @include('admin.components.link', [
                'name'  => 'Attach an existing resume',
                'href'  => route('admin.career.application.resume.attach', $application ?? null),
                'class'    => 'button is-primary my-0',
            ])


            <h4 class="subtitle has-text-centered pt-4">or</h4>

            @include('admin.components.link', [
                'name'  => 'Add a new resume',
                'href'  => route(
                                'admin.career.resume.create',
                                !empty($applicationId) ? ['application_id' => $applicationId] : []
                            ),
                'class'    => 'button is-primary my-0',
            ])

        </div>

    @else

        <div style="height: 12px; margin: 0; padding: 0;"></div>

        <div style="display: flex; align-items: flex-start; column-gap: 20px; max-width: 30rem;">

            <div style="flex: 1; padding: 5px;">

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
                    'target' => '_blank',
                    'style'  => 'white-space: nowrap'
                ])

                @include('admin.components.show-row-link', [
                    'name'   => 'PDF doc',
                    'label'  => !empty($resume->pdf_url) ? '<i class="fa-solid fa-download"></i>download' : '',
                    'href'   => !empty($resume->pdf_url) ? route('download-from-public', [ 'file' => $resume->pdf_url, 'name' => $resume->slug ]) : null,
                    'target' => '_blank',
                    'style'  => 'white-space: nowrap'
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

            </div>

            @if(!empty($resume->pdf_url))

                <div style="flex: 1; padding: 5px;">
                    <iframe src="{{ str_replace('\\', '/', $resume->pdf_url) }}"
                            style="width:100%; min-height:300px; border: 1px solid #ccc;">
                    </iframe>
                </div>

            @elseif(!empty($resume->doc_url))

                <div style="flex: 1; padding: 5px;">
                    <iframe src="{{ route('view-document', ['file' => $resume->pdf_url]) }}"
                            style="width:100%; min-height:300px; border: 1px solid #ccc;">
                    </iframe>
                </div>

            @endif

        </div>

    @endif

</div>
