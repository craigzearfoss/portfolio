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
                                            <div class="form-group">
                                                <strong>role</strong>: {{ $application->role }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>rating</strong>:
                                                @for ($star=1; $star<$application->rating; $star++)
                                                    <i class="fa-solid fa-star"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>active</strong>:
                                                @include('admin.components.checkmark', [ 'checked' => $application->active ])
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>post date</strong>:
                                                {{ longDate($application->post_date) }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>apply date</strong>:
                                                {{ longDate($application->apply_date) }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>close date</strong>:
                                                {{ longDate($application->close_date) }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>compensation</strong>:
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
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>duration</strong>: {{ $application->duration }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>type</strong>:
                                                {{ \App\Models\Career\Application::typeName($application->type) }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>office</strong>:
                                                {{ \App\Models\Career\Application::officeName($application->office) }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>location</strong>:
                                                @if ($application->city)
                                                    {{ $application->city }}@if ($application->state), {{ $application->state }}@endif
                                                @else
                                                    {{ $application->state }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>bonus</strong>: ${{ $application->bonus }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>w2</strong>:
                                                @include('admin.components.checkmark', [ 'checked' => $application->w2 ])
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>relocation</strong>:
                                                @include('admin.components.checkmark', [ 'checked' => $application->relocation ])
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>benefits</strong>:
                                                @include('admin.components.checkmark', [ 'checked' => $application->benefits ])
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>vacation</strong>:
                                                @include('admin.components.checkmark', [ 'checked' => $application->vacation ])
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>health</strong>:
                                                @include('admin.components.checkmark', [ 'checked' => $application->health ])
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>source</strong>: {{ $application->source }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>link</strong>:
                                                @include('admin.components.link', [ 'url' => $application->link, 'target' => '_blank' ])
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>contact(s)</strong>: {{ $application->contacts }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>phone(s)</strong>: {{ $application->phones }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>email(s)</strong>: {{ $application->emails }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>website</strong>:
                                                @include('admin.components.link', [ 'url' => $application->website, 'target' => '_blank' ])
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>description</strong>: {{ $application->description }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>created at</strong>:
                                                {{ longDateTime($application->created_at) }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>updated at</strong>:
                                                {{ longDateTime($application->updated_at) }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>deleted at</strong>:
                                                {{ longDateTime($application->deleted_at) }}
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
