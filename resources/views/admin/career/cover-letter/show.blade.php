@php
    use App\Enums\PermissionEntityTypes;

    $title = $pageTitle ?? 'Cover Letter: ' . $coverLetter->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',             'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',           'href' => route('admin.career.index') ],
        [ 'name' => 'Cover Letters',    'href' => route('admin.career.cover-letter.index') ],
        [ 'name' => $coverLetter->name ],
    ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $coverLetter, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.career.cover-letter.edit', $coverLetter)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'cover-letter', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Cover Letter', 'href' => route('admin.career.cover-letter.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.career.cover-letter.index')])->render();

    $fileExtension = !empty($coverLetter->filepath)
        ? Illuminate\Support\Facades\File::extension($coverLetter->filepath)
        : '';
@endphp
@extends('admin.layouts.default', [
    'title'         => $title,
    'subtitle'      => $subtitle,
    'breadcrumbs'   => $breadcrumbs,
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'menuService'   => $menuService,
    'admin'         => $admin,
    'user'          => $user,
    'owner'         => $owner,
])

@section('content')

    <section class="section p-0">

        <div class="container show-container">
            <div class="columns is-12 is-variable">
                <div class="column is-12-tablet">

                    <!-- tabbed content -->
                    <div class="tabs is-boxed mb-2">
                        <ul>
                            <li class="is-active" data-target="cover-letter">
                                <a>Cover Letter</a>
                            </li>
                            <li data-target="details">
                                <a>Details</a>
                            </li>

                        </ul>

                        <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
                            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
                        </div>

                    </div>

                    <div class="px-2" id="tab-content">

                        <div id="cover-letter">

                            <div class="show-container card p-4">

                                @include('admin.components.show-row', [
                                    'name'    => 'application',
                                    'value'   => view('admin.components.link', [
                                                     'name' => $coverLetter->name,
                                                     'href' => route('admin.career.application.show', $coverLetter->application),
                                                 ]),
                                    'message' => $message ?? '',
                                ])

                                @if (!empty($coverLetter->filepath))

                                    @if(in_array($fileExtension, ['doc', 'docx']))

                                        @include('admin.components.show-row-link', [
                                            'name'   => $fileExtension . ' file',
                                            'label'  => '<i class="fa-solid fa-download"></i>download',
                                            'href'   => route('download-from-public', [ 'file' => $coverLetter->filepath, 'name' => $coverLetter->slug ]),
                                            'target' => '_blank',
                                            'style'  => 'white-space: nowrap'
                                        ])

                                            <iframe src="{{ route('view-document', [ 'file' => $coverLetter->filepath ]) }}"
                                                    style="width:100%; min-height:400px; border: 1px solid #ccc;">
                                            </iframe>

                                    @else

                                        @include('admin.components.show-row-link', [
                                            'name'   => $fileExtension . ' file',
                                            'label'  => '<i class="fa-solid fa-download"></i>download',
                                            'href'   => route('download-from-public', [ 'file' => $coverLetter->filepath, 'name' => $coverLetter->slug ]),
                                            'target' => '_blank',
                                            'style'  => 'white-space: nowrap'
                                        ])

                                            <iframe src="{{ route('view-document', ['file' => $coverLetter->filepath]) }}"
                                                    style="width:100%; min-height:300px; border: 1px solid #ccc;">
                                            </iframe>

                                    @endif

                                @endif

                            </div>

                        </div>

                        <div id="details">

                            <div class="show-container card p-4">

                                @include('admin.components.show-row', [
                                    'name'  => 'id',
                                    'value' => $coverLetter->id
                                ])

                                @if($admin->root)
                                    @include('admin.components.show-row', [
                                        'name'  => 'owner',
                                        'value' => $coverLetter->owner->username
                                    ])
                                @endif

                                @include('admin.components.show-row', [
                                    'name'    => 'application',
                                    'value'   => view('admin.components.link', [
                                                     'name' => $coverLetter->name,
                                                     'href' => route('admin.career.application.show', $coverLetter->application),
                                                 ]),
                                    'message' => $message ?? '',
                                ])

                                @include('admin.components.show-row-link', [
                                    'name'  => 'date',
                                    'value' => longDate($coverLetter->date)
                                ])

                                @include('admin.components.show-row-link', [
                                    'name'   => $fileExtension . ' file',
                                    'label'  => !empty($coverLetter->filepath) ? '<i class="fa-solid fa-download"></i>download' : '',
                                    'href'   => !empty($coverLetter->filepath)
                                                    ? route('download-from-public', [ 'file' => $coverLetter->filepath,
                                                                                      'name' => $coverLetter->slug ]
                                                            )
                                                    : '',
                                    'target' => '_blank',
                                    'style'  => 'white-space: nowrap'
                                ])

                                <?php /*
                                @include('admin.components.show-row', [
                                    'name'  => 'content',
                                    'value' => $coverLetter->content
                                ])
                                */ ?>

                                @include('admin.components.show-row', [
                                    'name'  => 'notes',
                                    'value' => $coverLetter->notes
                                ])

                                @include('admin.components.show-row-link', [
                                    'name'   => !empty($coverLetter->link_name) ? $coverLetter->link_name : 'link',
                                    'href'   => $coverLetter->link,
                                    'target' => '_blank'
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'description',
                                    'value' => $coverLetter->description
                                ])

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

                    </div>

                </div>
            </div>
        </div>

    </section>

@endsection
