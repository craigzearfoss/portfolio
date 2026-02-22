@php
    use App\Models\System\Owner;
    use App\Models\Portfolio\Video;

    $title    = $pageTitle ?? 'Video: ' . $video->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Videos',     'href' => route('admin.portfolio.video.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => $video->name, 'href' => route('admin.portfolio.video.show', [$video, 'owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Videos',     'href' => route('admin.portfolio.video.index') ];
        $breadcrumbs[] = [ 'name' => $video->name, 'href' => route('admin.portfolio.video.show', $video) ];
    }
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.video.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.video.update', array_merge([$video], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.video.index')
            ])


            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $video->id
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $video->owner_id,
                    'required' => true,
                    'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $video->owner_id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $video->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'parent_id',
                'label'   => 'parent',
                'value'   => old('parent_id') ?? $video->parent_id,
                'list'    => new Video()->listOptions([ 'id <>' => $video->id ], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'featured',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('featured') ?? $video->featured,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'summary',
                'value'     => old('summary') ?? $video->summary,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'full_episode',
                                'label'           => 'full episode',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('full_episode') ?? $video->full_episode,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'clip',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('clip') ?? $video->clip,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'public_access',
                                'label'           => 'public access',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('public_access') ?? $video->public_access,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'source_recording',
                                'label'           => 'source recording',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('source_recording') ?? $video->source_recording,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-input-horizontal', [
                'type'      => 'date',
                'name'      => 'date',
                'value'     => old('date') ?? $video->date,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'number',
                'name'      => 'year',
                'value'     => old('year') ?? $video->year,
                'min'       => 1950,
                'max'       => date('Y'),
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'company',
                'value'     => old('company') ?? $video->company,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'credit',
                'value'   => old('credit') ?? $video->credit,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'show',
                'value'     => old('show') ?? $video->show,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'location',
                'value'     => old('location') ?? $video->location,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'embed',
                'value'   => old('embed') ?? $video->embed,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'video_url',
                'label'     => 'video url',
                'value'     => old('video_url') ?? $video->video_url,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $video->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $video->link,
                'name' => old('link_name') ?? $video->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $video->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $video->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $video->image,
                'credit'  => old('image_credit') ?? $video->image_credit,
                'source'  => old('image_source') ?? $video->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $video->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'public'      => old('public')   ?? $video->public,
                'readonly'    => old('readonly') ?? $video->readonly,
                'root'        => old('root')     ?? $video->root,
                'disabled'    => old('disabled') ?? $video->disabled,
                'demo'        => old('demo')     ?? $video->demo,
                'sequence'    => old('sequence') ?? $video->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.portfolio.video.index')
            ])

        </form>

    </div>

@endsection
