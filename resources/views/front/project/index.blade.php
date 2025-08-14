@extends('front.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('front.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('front.components.header')

                @include('front.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Projects</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('front.components.messages', [$errors])
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th></th>
                            <th>name</th>
                            <th>professional</th>
                            <th>personal</th>
                            <th>year</th>
                            <th>repository</th>
                            <th>link</th>
                            <th>description</th>
                            <th>actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($projects as $project)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $project->name }}</td>
                                <td class="text-center">
                                    @include('front.components.checkmark', [ 'checked' => $project->professional ])
                                </td>
                                <td class="text-center">
                                    @include('front.components.checkmark', [ 'checked' => $project->personal ])
                                </td>
                                <td>{{ $project->year }}</td>
                                <td>
                                    @include('front.components.link', [ 'url' => $project->repository, 'target' => '_blank' ])
                                </td>
                                <td>
                                    @include('front.components.link', [ 'url' => $project->link, 'target' => '_blank' ])
                                </td>
                                <td>{!! $project->description !!}</td>
                                <td>
                                    <a class="btn btn-sm" href="{{ route('front.project.show', $project->slug) }}"><i class="fa-solid fa-list"></i>{{-- Show--}}</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">There are no projects.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $projects->links() !!}

                    @include('front.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
