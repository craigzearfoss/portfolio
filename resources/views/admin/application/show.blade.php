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
                        <h3 class="card-header ml-3">Show Application</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] max-w-[800px] card-shadow" role="presentation">
                                <div class="card-body md:p-5">

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.application.edit', $application) }}"><i class="fa fa-pen-to-square"></i> Edit</a>                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.application.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>role</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ $application->role }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>rating</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.star-ratings', [ 'rating' => $application->rating ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>active</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.checkmark', [ 'checked' => $application->active ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2 text-nowrap"><strong>post date</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ longDate($application->post_date) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2 text-nowrap"><strong>apply date</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ longDate($application->apply_date) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2 text-nowrap"><strong>close date</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ longDate($application->close_date) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>compensation</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @if ($application->compensation)
                                                        {{ explode('.', Number::currency($application->compensation))[0] }}
                                                        @if ($application->compensation_unit)
                                                            / {{ $application->compensation_unit }}
                                                        @endif
                                                    @else
                                                        ?
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>duration</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ $application->duration }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>type</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ \App\Models\Career\Application::typeName($application->type) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>office</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ \App\Models\Career\Application::officeName($application->office) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>location</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @if ($application->city)
                                                        {{ $application->city }}@if ($application->state), {{ $application->state }}@endif
                                                    @else
                                                        {{ $application->state }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>bonus</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    ${{ $application->bonus }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>w2</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.checkmark', [ 'checked' => $application->w2 ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>relocation</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.checkmark', [ 'checked' => $application->relocation ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>benefits</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.checkmark', [ 'checked' => $application->benefits ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>vacation</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.checkmark', [ 'checked' => $application->vacation ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>health</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.checkmark', [ 'checked' => $application->health ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>source</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ $application->source }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>link</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.link', [ 'url' => $application->link, 'target' => '_blank' ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>contact(s)</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ $application->contacts }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>phone(s)</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ $application->emails }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>email(s)</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ $application->emails }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>website</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.link', [ 'url' => $application->website, 'target' => '_blank' ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>description</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ $application->description }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2 text-nowrap"><strong>created at</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ longDateTime($application->created_at) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2 text-nowrap"><strong>updated at</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ longDateTime($application->updated_at) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2 text-nowrap"><strong>deleted at</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ longDateTime($application->deleted_at) }}
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
