@extends('guest.layouts.default', [
    'title'         => $title ?? 'Audio: ' . $audio->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.admin.portfolio.show', $admin) ],
        [ 'name' => 'Audio',      'href' => route('guest.admin.portfolio.audio.index', $admin) ],
        [ 'name' => $audio->name ],
    ],
    'buttons'       => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.admin.portfolio.audio.index', $admin) ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => $admin ?? null,
])

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $audio->disclaimer ?? null ])

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($audio->name ?? '')
        ])

        @if(!empty($audio->parent))
            @include('guest.components.show-row', [
                'name'  => 'parent',
                'value' => !empty($audio->parent)
                    ? view('guest.components.link', [
                            'name' => htmlspecialchars($audio->parent['name'] ?? ''),
                            'href' => route('guest.admin.portfolio.audio.show', [$admin, $audio->parent->slug])
                        ])
                    : ''
            ])
        @endif

        <?php /*
        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $audio->featured
        ])
        */
        ?>

        @include('guest.components.show-row', [
            'name'  => 'summary',
            'value' => $audio->summary ?? ''
        ])

        @if(!empty($audio->children))
            <div class="columns">
                <div class="column is-2"><strong>children</strong>:</div>
                <div class="column is-10 pl-0">
                    <ol>
                        @foreach($audio->children as $child)
                            <li>
                                @include('guest.components.link', [
                                    'name' => htmlspecialchars($child['name'] ?? ''),
                                    'href' => route('guest.admin.portfolio.audio.show', [$admin, $child->slug])
                                ])
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        @endif

        @if(!empty($audio->full_episode))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'full episode',
                'checked' => $audio->full_episode
            ])
        @endif

        @if(!empty($audio->clip))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'clip',
                'checked' => $audio->clip
            ])
        @endif

        @if(!empty($audio->podcast))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'podcast',
                'checked' => $audio->podcast
            ])
        @endif

        @if(!empty($audio->source_recording))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'source recording',
                'checked' => $audio->source_recording
            ])
        @endif

        @if(!empty($audio->date))
            @include('guest.components.show-row', [
                'name'  => 'date',
                'value' => longDate($audio->date)
            ])
        @endif

        @if(!empty($audio->year))
            @include('guest.components.show-row', [
                'name'  => 'year',
                'value' => $audio->year
            ])
        @endif

        @if(!empty($audio->company))
            @include('guest.components.show-row', [
                'name'  => 'company',
                'value' => htmlspecialchars($audio->company ??)
            ])
        @endif

        @if(!empty($audio->credit))
            @include('guest.components.show-row', [
                'name'  => 'credit',
                'value' => htmlspecialchars($audio->credit ?? '')
            ])
        @endif

        @if(!empty($audio->show))
            @include('guest.components.show-row', [
                'name'  => 'show',
                'value' => htmlspecialchars($audio->show ?? '')
            ])
        @endif

        @if(!empty($audio->location))
            @include('guest.components.show-row', [
                'name'  => 'location',
                'value' => htmlspecialchars($audio->location ?? '')
            ])
        @endif

        @if(!empty($audio->embed))
            @include('guest.components.show-row', [
                'name'   => 'embed',
                'value'  => $audio->embed,
            ])
        @endif

        @if(!empty($audio->audio_url))
            @include('guest.components.show-row', [
                'name'  => 'audio url',
                'value' => htmlspecialchars($audio->audio_url ?? ''),
            ])
        @endif

        @if(!empty($audio->link))
            @include('guest.components.show-row-link', [
                'name'   => htmlspecialchars($audio->link_name ?? 'link'),
                'href'   => htmlspecialchars($audio->link ?? ''),
                'target' => '_blank'
            ])
        @endif

        @if(!empty($audio->description ))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => $audio->description ?? ''
            ])
        @endif

        @if(!empty($audio->image))
            @include('guest.components.show-row-image', [
                'name'         => 'image',
                'src'          => $audio->image,
                'alt'          => $audio->name,
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($audio->name, $audio->image),
                'image_credit' => $audio->image_credit,
                'image_source' => $audio->image_source,
            ])
        @endif

        @if(!empty($audio->thumbnail))
            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $audio->thumbnail . ' thumbnail',
                'alt'      => $audio->name,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($audio->name . '-thumbnail', $audio->thumbnail)
            ])
        @endif

    </div>

@endsection
