@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\System\Environment';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $envSettings = $envSettings ?? null;

    $title    = $pageTitle ?? 'Settings';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',             'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
        [ 'name' => 'System Dashboard', 'href' => route('system.index') ],
        [ 'name' => 'Environment' ],
    ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            <div class="columns is-12 is-variable">
                <div class="column is-12-tablet">

                    <!-- tabbed content -->
                    <div class="tabs is-boxed mb-2">

                        <ul>
                            <li id="initial-selected-tab" class="is-active" data-target="env-file">
                                <a>.env file</a>
                            </li>
                            <li data-target="composer-json-file">
                                <a>composer.json</a>
                            </li>
                            <li data-target="composer-lock-file">
                                <a>composer.lock</a>
                            </li>
                            <li data-target="package-json-file">
                                <a>package.json</a>
                            </li>
                            <li data-target="package-lock-file">
                                <a>package-json.lock</a>
                            </li>

                        </ul>

                    </div>

                    <div class="px-2" id="tab-content">

                        <div id="env-file">

                            <h2 class="title">.env file</h2>

                            <table class="table {{ $adminTableClasses ?? '' }}">
                                <thead>
                                <tr>
                                    <th>setting</th>
                                    <th>value</th>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach ($envSettings as $setting=>$value)

                                    @php
                                        $commentedOut = $textColor = (!empty($value) && str_starts_with($value, '#'));
                                    @endphp

                                    <tr>
                                        <td>
                                            <code
                                                class="{{ $commentedOut ? 'has-text-grey' : 'has-text-black' }} has-background-white">
                                                {{ $commentedOut ? '#' . $setting : $setting }}
                                            </code>
                                        </td>
                                        <td>
                                            <code
                                                class="{{ $commentedOut ? 'has-text-grey' : 'has-text-black' }} has-background-white">
                                                {{ $commentedOut ? ltrim($value, '#') : $value }}
                                            </code>
                                        </td>
                                    </tr>

                                @endforeach

                                </tbody>

                            </table>

                        </div>

                        <div id="composer-json-file">

                            <h2 class="title">composer.json file</h2>

                            <textarea cols="100"
                                      rows="40"
                            >{{ $composerJsonContent }}</textarea>

                        </div>

                        <div id="composer-lock-file">

                            <h2 class="title">composer.lock file</h2>

                            <textarea cols="100"
                                      rows="40"
                            >{{ $composerLockContent }}</textarea>

                        </div>

                        <div id="package-json-file">

                            <h2 class="title">package.json file</h2>

                            <textarea cols="100"
                                      rows="40"
                            >{{ $packageJsonContent }}</textarea>

                        </div>

                        <div id="package-lock-file">

                            <h2 class="title">package-json.lock file</h2>

                            <textarea cols="100"
                                      rows="40"
                            >{{ $packageLockContent }}</textarea>

                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
