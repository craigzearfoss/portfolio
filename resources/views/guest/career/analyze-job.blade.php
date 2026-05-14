@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\Art';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = 'Analyze Job';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home', 'href' => route('guest.index') ],
        [ 'name' => 'Analyze Job' ],
    ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    <div class="floating-div-container">

        <div class="container show-container ml-0" style="max-width: 56rem;">

            <input type="text" id="search_terms" name="search_terms" style="width: 40rem;">


<?php /*
            @foreach ($applicationSkills as $i=>$applicationSkill)

                <div style="display: inline-block; width: 10rem;">

                    <div style="display: inline-block;">
                        <input type="hidden" name="application_skill[]" value="0">
                        <input type="checkbox">
                    </div>
                    <label for="checkBoxSkill_{{ Str::slug($applicationSkill['name']) }}">{{ $applicationSkill['name'] }}</label>

                </div>

            @endforeach
            */ ?>

        </div>

    </div>

    <div class="container show-container ml-0" style="max-width: 60rem;">

        <div class="p-4">

            <form action="{{ route('admin.career.application.analyze-post') }}" method="post">
                @csrf

                <div>
                    <span>Paste the job description in the text box and click on the "Submit" button.</span>
                    <span class="has-text-right" style="float: right;">
                        <button type="submit" id="submitAnalyze" class="button is-small is-dark">
                            <i class="fa fa-floppy-disk"></i>
                            Analyze
                        </button>
                    </span>
                    <span class="has-text-right mr-2" style="float: right;">
                        <button type="button" id="clearAnalyze" class="button is-small is-dark">
                           <i class="fa fa-eraser"></i>
                            Clear
                        </button>
                    </span>
                </div>

                @include('admin.components.form-textarea', [
                    'name'  => 'description',
                    'id'    => 'inputEditor',
                    'label' => '',
                    'value' => '',
                    'rows'  => 10,
                    'class' => 'analyze-application-description',
                ])

            </form>

        </div>

    </div>

    <script>

        document.addEventListener('DOMContentLoaded', () => {

            document.getElementById('submitAnalyze').addEventListener('click', function(event) {
                event.preventDefault();
                let termsStr = document.getElementById('search_terms').value;
                if (!termsStr) {
                    alert('Please enter a list of comma-separated search terms.');
                } else {
                    let terms = termsStr.split(',').forEach((item) => { return 'A'; });
                    console.log(terms);
                }
            });

            document.getElementById('clearAnalyze').addEventListener('click', function(event) {
                event.preventDefault();
                window.editor.setData('');
            });
        });

    </script>

@endsection
