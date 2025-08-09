@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left')

            <div
                class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="page-container relative h-full flex flex-auto flex-col">
                    <div class="h-full">
                        <h3 class="card-header ml-3">Show Application</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] max-w-[800px] card-shadow"
                                 role="presentation">
                                <div class="card-body md:p-5">

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-solid btn-sm"
                                           href="{{ route('admin.application.edit', $application) }}"><i
                                                class="fa fa-pen-to-square"></i> Edit</a> <a
                                            class="btn btn-solid btn-sm"
                                            href="{{ route('admin.application.index') }}"><i
                                                class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                                    <div class="row">

                                        @include('admin.components.show-row', [
                                            'name'  => 'name',
                                            'value' => $application->role
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'company',
                                            'value' => $application->company['name'] ?? ''
                                        ])

                                        @include('admin.components.show-row-rating', [
                                            'name'  => 'rating',
                                            'value' => $application->rating
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'active',
                                            'checked' => $application->active
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'cover letter',
                                            'value' => $application->cover_letter['name'] ?? ''
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'resume',
                                            'value' => $application->resume['name'] ?? ''
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'post date',
                                            'value' => longDate($application->post_date)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'apply date',
                                            'value' => longDate($application->apply_date)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'close date',
                                            'value' => longDate($application->close_date)
                                        ])

                                        @include('admin.components.show-row-compensation', [
                                            'name'  => 'compensation',
                                            'value' => $application->compensation,
                                            'unit'  => $application->compensation_unit
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'duration',
                                            'value' => $application->duration
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'type',
                                            'value' => \App\Models\Career\Application::typeName($application->type)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'office',
                                            'value' => \App\Models\Career\Application::officeName($application->office)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'city',
                                            'value' => $application->city
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'state',
                                            'value' => \App\Models\State::getName($application->state)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'bonus',
                                            'value' => !empty($application->bonus) ? '$' . $application->bonus : ''
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'w2',
                                            'checked' => $application->w2
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'relocation',
                                            'checked' => $application->relocation
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'benefits',
                                            'checked' => $application->benefits
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'vacation',
                                            'checked' => $application->vacation
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'health',
                                            'checked' => $application->health
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'source',
                                            'value' => $application->source
                                        ])

                                        @include('admin.components.show-row-link', [
                                            'name'   => 'link',
                                            'url'    => $application->link,
                                            'target' => '_blank'
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'contact(s)',
                                            'value' => $application->contacts
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'phone(s)',
                                            'value' => $application->phones
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'emails(s)',
                                            'value' => $application->emails
                                        ])

                                        @if (!empty($application->website))
                                            @include('admin.components.show-row-link', [
                                                'name'   => 'website',
                                                'url'    => $application->website,
                                                'target' => '_blank'
                                            ])
                                        @endif

                                        @include('admin.components.show-row', [
                                            'name'  => 'description',
                                            'value' => $application->description
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'owner',
                                            'value' => $application->admin['username'] ?? ''
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'created at',
                                            'value' => longDateTime($application->created_at)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'updated at',
                                            'value' => longDateTime($application->updated_at)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'deleted at',
                                            'value' => longDateTime($application->deleted_at)
                                        ])

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
