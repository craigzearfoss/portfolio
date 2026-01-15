@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? 'Job: ' . $job->name . (!empty($job->year) ? ' - ' . $job->year : ''),
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('home') ],
        [ 'name' => 'Users',      'href' => route('home') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $admin) ],
        [ 'name' => 'Job',        'href' => route('guest.portfolio.job.index', $admin) ],
        [ 'name' => $job->name . (!empty($job->year) ? ' - ' . $job->year : '') ],
    ],
    'buttons'          => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.admin.portfolio.job.index', $admin) ],
    ],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
])

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $job->disclaimer ])

    <div class="show-container p-4">

        <h2>TBD</h2>

    </div>

@endsection
