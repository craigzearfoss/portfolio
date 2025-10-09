@extends('guest.layouts.empty', [
    'title' => '403 Forbidden',
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="container">
        <div class="section">
            <div class="columns">
                <div class="column is-three-fifths is-offset-one-fifth">
                    <div class="box has-text-centered">
                        <h1 class="title">403 Forbidden</h1>
                        <p>You tried to access a page for which you are not authorized.</p>

                        <p>If you are the application owner check the logs for more information.</p>
                    </div>
                    <div>
                        @if(isAdmin())
                            @include('admin.components.link', [
                                'name' => 'Back',
                                'href' => route('admin.dashboard')
                            ])
                        @elseif(isUser())
                            @include('admin.components.link', [
                                'name' => 'Back',
                                'href' => route('user.dashboard')
                            ])
                        @else
                            @include('admin.components.link', [
                                'name' => 'Back',
                                'href' => route('guest.homepage')
                            ])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
