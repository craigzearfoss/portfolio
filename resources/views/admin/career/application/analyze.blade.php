@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Career\Application';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = 'Analyze Application Description';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Applications',    'href' => route('admin.career.application.index') ],
        [ 'name' => 'Analyze' ],
    ];

    // set navigation buttons
    $navButtons = [];
    $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Application',
                                                                  'href' => route('admin.career.application.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                            ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <section class="section pt-0">

        <div class="container show-container ml-0" style="max-width: 60rem;">

            <div class="p-4">

                <form action="{{ route('admin.career.application.analyze-post') }}" method="post">
                    @csrf

                    @if ($admin['is_root'])
                        <div class="search-form-control mb-4">
                            @include('admin.components.search-panel.controls.system-owner', [
                                'id'       => 'application_analyze_owners_list',
                                'owner_id' => $owner_id,
                                'class'    => [ 'load-page-select-list' ],
                                'attributes' => [
                                    'data-url' => route('admin.career.application.analyze')
                                ],
                            ])
                        </div>
                    @endif

                    <div class="card ml-0">

                        <div class="card-header p-2">
                            <span class="has-text-weight-semibold">
                                Skills
                                @if ($isPost)
                                    <span class="is-size-6" style="font-weight: 400;"><i>({{ count($matchedSkills) }} {{ (count($matchedSkills) == 1) ? 'match' : 'matches' }} found.)</i></span>
                                @endif
                            </span>
                            <span style="position: absolute; right: 4px;">

                                <button type="button"
                                        class="select-all-skills button is-small skill-select-all-button"
                                        @if ($isPost)
                                            style="display: none;"
                                        @endif
                                >Select All</button>

                                <button type="button"
                                        class="unselect-all-skills button is-small skill-select-all-button"
                                        @if ($isPost)
                                            style="display: none;"
                                        @endif
                                >Un-select All</button>

                            </span>
                        </div>

                        <div class="card-body p-2">

                            @foreach ($skills as $skill)

                                <div style="{{ in_array($skill, $selectedSkills) ? 'display: inline-block;' : 'display: none;' }} white-space: nowrap; width: 10rem;">

                                    <div style="display: inline-block;">

                                        @if ($isPost)

                                            @if (in_array($skill, $matchedSkills))
                                                <i class="skill-checkbox-icon fa fa-check ml-2"></i>
                                            @else
                                                <i class="skill-checkbox-icon fa fa-square-o ml-2"></i>
                                            @endif

                                        @endif

                                        <input type="checkbox"
                                               id="checkBoxSkill_{{ Str::slug($skill) }}"
                                               name="skill[]"
                                               value="{{ $skill }}"
                                               @if (!$isPost)
                                                    checked
                                               @else
                                                    style="display: none;"
                                               @endif
                                               class="skill-checkbox form-check-input"
                                                {{ !$isPost || in_array($skill, $selectedSkills) ? 'checked' : '' }}
                                        >

                                    </div>
                                    <label for="checkBoxSkill_{{ Str::slug($skill) }}">
                                        {{ $skill }}
                                    </label>

                                </div>

                            @endforeach

                        </div>

                    </div>

                    <div class="card ml-0">

                        <div class="card-header p-2">
                            <span class="has-text-weight-semibold">
                                Anti-Skills
                                @if ($isPost)
                                    <span class="is-size-6" style="font-weight: 400;"><i>({{ count($matchedAntiSkills) }} {{ (count($matchedAntiSkills) == 1) ? 'match' : 'matches' }}  found.)</i></span>
                                @endif
                            </span>
                            <span style="position: absolute; right: 4px;">

                                <button type="button"
                                        class="select-all-anti-skills button is-small skill-select-all-button"
                                        @if ($isPost)
                                            style="display: none;"
                                        @endif
                                >Select All</button>

                                <button type="button"
                                        class="unselect-all-anti-skills button is-small skill-select-all-button"
                                        @if ($isPost)
                                            style="display: none;"
                                        @endif
                                >Un-select All</button>

                            </span>
                        </div>

                        <div class="card-body p-2">

                            @foreach ($antiSkills as $antiSkill)

                                <div style="display: inline-block; white-space: nowrap; width: 10rem;">

                                    <div style="display: inline-block;">

                                        @if ($isPost)

                                            @if (in_array($antiSkill, $matchedAntiSkills))
                                                <i class="anti-skill-checkbox-icon fa fa-check ml-2"></i>
                                            @else
                                                <i class="anti-skill-checkbox-icon fa fa-square-o ml-2"></i>
                                            @endif

                                        @endif

                                        <input type="checkbox"
                                               id="checkBoxAntiSkill_{{ Str::slug($antiSkill) }}"
                                               name="anti_skill[]"
                                               value="{{ $antiSkill }}"
                                               @if (!$isPost)
                                                   checked
                                               @else
                                                   style="display: none;"
                                               @endif
                                               class="anti-skill-checkbox form-check-input"
                                                {{ !$isPost || in_array($antiSkill, $selectedAntiSkills) ? 'checked' : '' }}
                                        >
                                    </div>
                                    <label for="checkBoxAntiSkill_{{ Str::slug($antiSkill) }}">
                                        {{ $antiSkill }}
                                    </label>

                                </div>

                            @endforeach

                        </div>

                    </div>

                    <div>
                        <span>Paste the job description in the text box and click on the "Submit" button.</span>
                        <span class="has-text-right" style="float: right;">
                            @include('admin.components.form-button-submit', [
                                'label'          => 'Analyze',
                                'include_cancel' => false,
                            ])
                        </span>
                        @if ($isPost)
                            <span class="has-text-right mr-2" style="float: right;">
                                <button type="button" class="reset-analyze-job-description button is-small is-dark">
                                   <i class="fa fa-arrow-left"></i>
                                   Reset
                                </button>
                            </span>
                        @endif
                        <span class="has-text-right mr-2" style="float: right;">
                            <button type="button" class="clear-job-description button is-small is-dark">
                                <i class="fa fa-eraser"></i>
                                Clear
                            </button>
                        </span>

                    </div>

                    <div class="parsed-job-description box mt-4" {!! empty($parsedDescription) ? 'style="display: none;"' : '' !!}>
                        {!! $parsedDescription ?? '' !!}
                    </div>

                    <div class="source-job-description" {!! !empty($parsedDescription) ? 'style="display: none;"' : '' !!}>
                        @include('admin.components.form-textarea', [
                            'name'  => 'description',
                            'id'    => 'inputEditor',
                            'label' => '',
                            'value' => $description,
                            'rows'  => 10,
                            'class' => 'analyze-job-description',
                        ])
                    </div>

                </form>

            </div>

        </div>

    </section>

@endsection
