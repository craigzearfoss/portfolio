@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="page-container relative h-full flex flex-auto flex-col">
                    <div class="h-full">
                        <h3 class="card-header ml-3">Show Project</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] max-w-[800px] card-shadow" role="presentation">
                                <div class="card-body md:p-5">

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.project.edit', $project) }}"><i class="fa fa-pen-to-square"></i> Edit</a>                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.project.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>name</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ $project->name }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>professional</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.checkmark', [ 'checked' => $project->professional ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>personal</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.checkmark', [ 'checked' => $project->personal ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>year</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.link', [ 'url' => $project->year, 'target' => '_blank' ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>repository</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.link', [ 'url' => $project->repository, 'target' => '_blank' ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>sample link</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.link', [ 'url' => $project->link, 'target' => '_blank' ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>description</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {!! $project->description !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>public</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.checkmark', [ 'checked' => $project->public ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>disabled</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.checkmark', [ 'checked' => $project->disabled ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2 text-nowrap"><strong>created at</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ longDateTime($project->created_at) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2 text-nowrap"><strong>updated at</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ longDateTime($project->updated_at) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2 text-nowrap"><strong>deleted at</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ longDateTime($project->deleted_at) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    @include('admin.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
