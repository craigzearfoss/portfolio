@php
    $applicationId = $applicationId ?? null;
    $coverLetter   = $coverLetter ?? null;
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">

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
                   href="{!! route('admin.career.cover-letter.show', $coverLetter) !!}">
                    <i class="fa-solid fa-list"></i>
                </a>

                <a title="edit" class="button is-small px-1 py-0"
                   href="{!! route('admin.career.cover-letter.edit',$coverLetter->id) !!}">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>

                @if(!empty($coverLetter->url))
                    @include('admin.components.button-download', [ 'file' => $coverLetter->url,
                                                                   'name' =>$coverLetter->slug . '-cover-letter' ])
                @endif

                @include('admin.components.button-download', [ 'file' => '',
                                                               'name' =>$coverLetter->slug . '-cover-letter' ])

            @endif

        </span>

    </h3>

    <hr class="navbar-divider">

    <div style="height: 12px; margin: 0; padding: 0;"></div>

    @if(!empty($coverLetter))

        <div style="display: flex; align-items: flex-start; column-gap: 20px;">

            <div style="flex: 1; padding: 5px;">

                @include('admin.components.show-row-link', [
                    'name'  => 'date',
                    'value' => longDate($coverLetter->date),
                ])

                @if (!empty($coverLetter->url))

                    @if(in_array(Illuminate\Support\Facades\File::extension($coverLetter->fillepath), ['doc', 'docx']))

                        @include('admin.components.show-row-link', [
                            'name'   => 'Word doc',
                            'label'  => '<i class="fa-solid fa-download"></i>download',
                            'href'   => route('download-from-public', [ 'file' => $coverLetter->url, 'name' => $coverLetter->slug ]),
                            'target' => '_blank',
                            'style'  => 'white-space: nowrap'
                        ])

                        <div style="flex: 1; padding: 5px;">
                            <iframe src="{{ str_replace('\\', '/', $coverLetter->url) }}"
                                    style="width:100%; min-height:300px; border: 1px solid #ccc;">
                            </iframe>
                        </div>

                    @else

                        @include('admin.components.show-row-link', [
                            'name'   => 'PDF doc',
                            'label'  => '<i class="fa-solid fa-download"></i>download',
                            'href'   => route('download-from-public', [ 'file' => $coverLetter->url, 'name' => $coverLetter->slug ]),
                            'target' => '_blank',
                            'style'  => 'white-space: nowrap'
                        ])

                            <div style="flex: 1; padding: 5px;">
                                <iframe src="{{ route('view-document', ['file' => $coverLetter->url]) }}"
                                        style="width:100%; min-height:300px; border: 1px solid #ccc;">
                                </iframe>
                            </div>

                    @endif

                @endif

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
                    'value' => $coverLetter->notes
                ])

                @include('admin.components.show-row-link', [
                    'name'   => !empty($coverLetter->link_name) ? $coverLetter->link_name : 'link',
                    'href'   => $coverLetter->link,
                    'target' => '_blank'
                ])

                @if (!empty($coverLetter->description))
                    @include('admin.components.show-row', [
                        'name'  => 'description',
                        'value' => $coverLetter->description
                    ])
                @endif

                @include('admin.components.show-row', [
                    'name'  => 'disclaimer',
                    'value' => view('admin.components.disclaimer', [
                                    'value' => $coverLetter->disclaimer
                               ])
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

            </div>

        </div>

    @endif

</div>
