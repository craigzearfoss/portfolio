@php
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
@endphp

@extends('admin.layouts.default')

@section('content')

    <section class="section">

        @if ($admin['is_root'])
            <div class="floating-div">
                <div class="search-form-control">
                    @include('admin.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                </div>
            </div>
        @endif

        @if ($isPost)

            <div>

                @foreach ($applicationSkills as $applicationSkill)

                    <div style="display: inline-block; width: 10rem;">

                        <div style="display: inline-block;">
                            <input type="hidden" name="application_skill[}]" value="0">
                            <input type="checkbox"
                                   data-application_skill_id="{{ $applicationSkill['id'] }}"
                                   data-application_id="{{ $applicationSkill['application_id'] }}"
                                   data-name="{{ $applicationSkill['name'] }}"
                                   data-portfolio_skill_id="{{ $applicationSkill['id'] }}"
                                   name="application_skill[]"
                                   value="1"
                                   class="application-skill-checkbox form-check-input "
                                {{ $applicationSkill['found'] ? 'checked' : '' }}
                            >
                        </div>
                        <span>{{ $applicationSkill['name'] }}</span>

                    </div>

                @endforeach

            </div>

        @endif

        <div class="container show-container" style="max-width: 60rem;">

            <div class="p-4">

                <form action="{{ route('admin.career.application.analyze-post') }}" method="post">
                    @csrf

                    <div>
                        <span>Paste the job description in the text box and click on the "Submit" button.</span>
                        <span class="has-text-right" style="float: right;">
                            @include('admin.components.form-button-submit', [
                                'label'          => 'Analyze',
                                'include_cancel' => false,
                            ])
                        </span>
                        <span class="has-text-right mr-2" style="float: right;">
                            <button type="button" id="clearAnalyzeApplicationDescription" class="button is-small is-dark">
                               <i class="fa fa-floppy-disk"></i>
                                Clear
                            </button>
                        </span>
                    </div>

                    @include('admin.components.form-textarea', [
                        'name'  => 'description',
                        'id'    => 'inputEditor',
                        'label' => '',
                        'value' => $description,
                        'rows'  => 10,
                        'class' => 'analyze-application-description',
                    ])

                </form>

            </div>

        </div>

    </section>

@endsection
