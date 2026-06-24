@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\Education';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    use Illuminate\Support\Carbon;

    $title    = $pageTitle ?? filteredPageTitle('education', htmlspecialchars($owner->name));
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Education' ],
          ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @if ($owner->is_demo)
        @if ($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => htmlspecialchars($disclaimerMessage) ])
        @endif
    @endif

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            <table class="table guest-table {{ $guestTableClasses ?? '' }}" style="min-width: 30rem; max-width: 60rem; overflow-x: auto; overflow-y: hidden;">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'major',
                                'sort'  => 'major|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'degree',
                                'sort'  => 'degree_type_name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'school',
                                'sort'  => 'school_name|asc',
                            ])
                        </th>
                        <th class="has-text-centered hide-at-480">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'graduated',
                                'sort'  => 'graduation_date|desc',
                            ])
                        </th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($educations as $education)

                    <tr data-id="{{ $education->id }}" {!! $education->is_disabled ? 'class="disabled-text"' : '' !!}>
                        <td data-field="major" style="white-space: nowrap;">
                            @if ($education->featured)
                                <strong>
                                    {!! htmlspecialchars($education->major) !!}
                                    @if (!empty($education->minor)) {
                                        ({!! htmlspecialchars($education->minor) !!} minor)
                                    @endif
                                </strong>
                            @else
                                {!! htmlspecialchars($education->major) !!}
                                @if (!empty($education->minor))
                                    ({!! htmlspecialchars($education->minor) !!} minor)
                                @endif
                            @endif
                        </td>
                        <td data-field="degreeType.name" style="white-space: nowrap;">
                            @if (!empty($education->degreeType->name))
                            {!! htmlspecialchars($education->degreeType->name) !!}
                                <?php /*
                                @include('admin.components.link-icon', [
                                    'title'      => 'add to favorites',
                                    'icon'       => 'fa-heart',
                                    'border'     => false,
                                    'target'     => '_blank',
                                    'class'      => 'add-to-favorites',
                                    'attributes' => [ 'data-resource' => 'portfolio.course', 'data-id' => $course->id ]
                                ])
                                */ ?>
                            @endif
                        </td>
                        <td data-field="school.name" style="white-space: nowrap;">
                            {!! htmlspecialchars($education->school->name ?? '') !!}
                        </td>
                        <td data-field="graduation_date" class="has-text-centered hide-at-480" style="white-space: nowrap;">
                            @if (!empty($education->graduation_date))
                                {{ Carbon::parse($education->graduation_date)->format("F y") }}
                            @endif
                            @if (!empty($education->currently_enrolled))
                                (currently enrolled)
                            @endif
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7">No education found.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            {!! $educations->links('vendor.pagination.bulma') !!}

        </div>

    </div>

@endsection
