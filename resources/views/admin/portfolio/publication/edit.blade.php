@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Publication: ' . $publication->title,
    'breadcrumbs'      => [
        [ 'name' => 'Home',             'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',        'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Publications',     'href' => route('admin.portfolio.publication.index') ],
        [ 'name' => $publication->name, 'href' => route('admin.portfolio.publication.show', $publication->id) ],
        [ 'name' => 'Edit' ],
    ],
    'buttons'          => [
        view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.publication.index')])->render(),
    ],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.publication.update', $publication->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.publication.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $publication->id
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $publication->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $publication->owner_id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'title',
                'value'     => old('title') ?? $publication->title,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'parent_id',
                'label'   => 'parent',
                'value'   => old('parent_id') ?? $publication->parent_id,
                'list'    => \App\Models\Portfolio\Publication::listOptions(['id <>' => $publication->id], 'id', 'title', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'featured',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('featured') ?? $publication->featured,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'summary',
                'value'     => old('summary') ?? $publication->summary,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'publication_name',
                'label'     => 'publication name',
                'value'     => old('publication_name') ?? $publication->publication_name,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'publisher',
                'value'     => old('publisher') ?? $publication->publisher,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'date',
                'name'      => 'date',
                'value'     => old('date') ?? $publication->date,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'number',
                'name'      => 'year',
                'value'     => old('year') ?? $publication->year,
                'min'       => 1980,
                'max'       => now("Y"),
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'credit',
                'value'     => old('credit') ?? $publication->credit,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'freelance',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('freelance') ?? $publication->freelance,
                'message'         => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'fiction',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('fiction') ?? $publication->fiction,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'nonfiction',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('nonfiction') ?? $publication->nonfiction,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'technical',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('technical') ?? $publication->technical,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'research',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('research') ?? $publication->research,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'poetry',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('poetry') ?? $publication->poetry,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'online',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('online') ?? $publication->online,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'novel',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('novel') ?? $publication->novel,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'book',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('book') ?? $publication->book,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'label'           => 'textbook',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('textbook') ?? $publication->summary,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'label'           => 'article',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('article') ?? $publication->article,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'label'           => 'pamphlet',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('pamphlet') ?? $publication->pamphlet,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-input-horizontal', [
                'name'      => 'publication_url',
                'label'     => 'publication url',
                'value'     => old('publication_url') ?? $publication->publication_url,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $publication->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $publication->link,
                'name' => old('link_name') ?? $publication->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $publication->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $publication->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'image'   => old('image') ?? $publication->image,
                'credit'  => old('image_credit') ?? $publication->image_credit,
                'source'  => old('image_source') ?? $publication->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'thumbnail',
                'value'     => old('thumbnail') ?? $publication->thumbnail,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'   => old('public') ?? $publication->public,
                'readonly' => old('readonly') ?? $publication->readonly,
                'root'     => old('root') ?? $publication->root,
                'disabled' => old('disabled') ?? $publication->disabled,
                'demo'     => old('demo') ?? $publication->demo,
                'sequence' => old('sequence') ?? $publication->sequence,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.portfolio.publication.index')
            ])

        </form>

    </div>

@endsection
