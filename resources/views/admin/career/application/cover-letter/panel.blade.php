@php
    $applicationId = $applicationId ?? null;
    $coverLetter   = $coverLetter ?? null;

    $filename = str_replace('CoverLetter: ', '', getResourcePageTitle($coverLetter, false));

    $fileExtension = !empty($coverLetter->filepath)
        ? Illuminate\Support\Facades\File::extension($coverLetter->filepath)
        : '';
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">

        Cover Letter

        <span style="display: inline-flex; float: right;">

            @if (empty($coverLetter))

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

                @if (!empty($coverLetter->url))
                    @include('admin.components.button-download', [ 'file' => $coverLetter->url,
                                                                   'name' =>$coverLetter->slug . '-cover-letter' ])
                @endif

            @endif

        </span>

    </h3>

    <hr class="navbar-divider">

    <div style="height: 12px; margin: 0; padding: 0;"></div>

    @if (!empty($coverLetter))

        <div style="display: flex; align-items: flex-start; column-gap: 20px;">

            <div style="flex: 1; padding: 5px;">

                @include('admin.components.show-row-link', [
                    'name'  => 'date',
                    'value' => longDate($coverLetter->cover_letter_datetime),
                ])

                @include('admin.components.show-row-document', [
                    'resource'        => $coverLetter,
                    'label'           => 'file',
                    'filename'        => $coverLetter->name,
                    'column'          => 'filepath',
                    'datetime_column' => 'cover_letter_datetime',
                    'upload'          => false,
                    'download'        => true,
                    'external'        => true,
                ])

                @include('admin.components.show-row', [
                    'name'  => 'notes',
                    'value' => $coverLetter->notes
                ])

                @include('admin.components.show-row-link', [
                    'name'   => !empty($coverLetter->link_name) ? htmlspecialchars($coverLetter->link_name) : 'link',
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

                @include('admin.components.show-row-visibility', [
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
