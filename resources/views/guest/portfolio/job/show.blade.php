@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? 'Job: ' . $job->name . (!empty($job->year) ? ' - ' . $job->year : ''),
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('home') ],
        [ 'name' => 'Users',      'href' => route('home') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Job',        'href' => route('guest.portfolio.job.index', $owner) ],
        [ 'name' => $job->name . (!empty($job->year) ? ' - ' . $job->year : '') ],
    ],
    'buttons'          => [
        view('guest.components.nav-button-back', ['href' => referer('guest.admin.portfolio.job.index', $owner)])->render(),
    ],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $job->disclaimer ])

    <div class="show-container p-4">

        <h2>TBD</h2>

    </div>

@endsection
