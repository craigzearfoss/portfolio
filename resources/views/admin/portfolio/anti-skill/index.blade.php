@php
    use App\Models\Portfolio\AntiSkill;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Portfolio\Skill';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Anti-Skills';
    $subtitle = $title . '<br><i style="font-size: 0.9rem; font-weight: 500;">These are skill that you do NOT have that are used when analyzing job descriptions.</i>';

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Anti-Skills' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(AntiSkill::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Anti-Skill',
                                                                  'href' => route('admin.portfolio.anti-skill.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-skill', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container" style="max-width: 80em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.portfolio.anti-skill.export', request()->except([ 'page' ])),
                'filename' => 'anti_skills_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($antiSkills->total()) }} {{ ($antiSkills->total() === 1) ? 'anti-skill' : 'anti-skills' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $antiSkills->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured anti skill. <span class="sample-color-box-light-gray"></span> indicates the anti skill is disabled.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        @if ($isRootAdmin)
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'id',
                                    'sort'  => 'id|asc',
                                ])
                            </th>
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'owner',
                                    'sort'  => 'owner_username|asc',
                                ])
                            </th>
                        @endif
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'name',
                                'sort'  => 'name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'category',
                                'sort'  => 'dictionary_category_name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'level',
                                'sort'  => 'level|desc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'years',
                                'sort'  => 'years|asc',
                            ])
                        </th>
                        <th>public</th>
                        <th>disabled</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($antiSkills as $antiSkill)

                    <tr data-id="{{ $antiSkill->id }}" {!! $antiSkill->is_disabled ? 'class="disabled-text"' : '' !!}>
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $antiSkill->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name'  => $antiSkill->owner->username,
                                    'href'  => route('admin.system.admin.show', $antiSkill->owner),
                                    'class' => $antiSkill->is_disabled ? [ 'disabled-text' ] : []
                                ])
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            @include('admin.components.link', [
                                'name'  => $antiSkill->name
                                             . (!empty($antiSkill->version) ? ' ' . $antiSkill->version : '')
                                             . (!empty($antiSkill->featured) ? '<span class="featured-splat">*</span>' : ''),
                                'href'  => route('admin.portfolio.anti-skill.show', $antiSkill),
                                'class' => $antiSkill->is_disabled ? [ 'disabled-text' ] : []
                            ])
                        </td>
                        <td data-field="dictionary_category_id" style="white-space: nowrap;">
                             @if (!empty($antiSkill->category->name))
                                 {{ $antiSkill->category->name }}
                             @endif
                        </td>
                        <td data-field="level" style="white-space: nowrap;">
                            @include('admin.components.star-ratings', [
                                'rating' => $antiSkill->level,
                                'max'    => 10,
                                'label'  => !empty($antiSkill->level) ? "({$antiSkill->level})" : '',
                            ])
                        </td>
                        <td data-field="years" class="has-text-centered">
                            {{ $antiSkill->years }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $antiSkill->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $antiSkill->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($antiSkill, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.anti-skill.show', ownerParams($antiSkill, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($antiSkill, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.anti-skill.edit', ownerParams($antiSkill, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($antiSkill->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($antiSkill->link_name) ? $antiSkill->link_name : 'link',
                                        'href'   => $antiSkill->link,
                                        'icon'   => 'fa-external-link',
                                        'target' => '_blank'
                                    ])
                                @else
                                    @include('admin.components.link-icon', [
                                        'title'    => 'link',
                                        'icon'     => 'fa-external-link',
                                        'disabled' => true
                                    ])
                                @endif

                                @if (canDelete($antiSkill, $admin))
                                    <form class="delete-resource" action="{!! route('admin.portfolio.anti-skill.destroy', $antiSkill) !!}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        @include('admin.components.button-icon', [
                                            'title' => 'delete',
                                            'class' => 'delete-btn',
                                            'icon'  => 'fa-trash'
                                        ])
                                    </form>
                                @endif

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ $isRootAdmin ? '9' : '7' }}">No skills found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $antiSkills->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
