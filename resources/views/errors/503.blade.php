@extends('guest.layouts.blank', [
    'title' => '503 Service Unavailable',
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
                        <h1 class="title">We'll be right back!</h1>
                        <div>
                            <p>Sorry for the inconvenience but we're performing some maintenance at the moment. We'll be back online shortly!</p>
                            <p>&mdash; The Team</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
