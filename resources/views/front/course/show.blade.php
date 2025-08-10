@extends('front.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('front.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('front.components.header')

                @include('front.components.popup')

                <div class="page-container relative h-full flex flex-auto flex-col">
                    <div class="h-full">
                        <h3 class="card-header ml-3">Show Course</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] max-w-[800px] card-shadow" role="presentation">
                                <div class="card-body md:p-5">

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-solid btn-sm" href="{{ route('course.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                                    <div class="row">

                                        @include('front.components.show-row', [
                                            'name'  => 'name',
                                            'value' => $course->name
                                        ])

                                        @include('front.components.show-row-checkbox', [
                                            'name'    => 'professional',
                                            'checked' => $course->professional
                                        ])

                                        @include('front.components.show-row-checkbox', [
                                            'name'    => 'personal',
                                            'checked' => $course->personal
                                        ])

                                        @include('front.components.show-row', [
                                            'name'  => 'completed',
                                            'value' => longDate($course->completed)
                                        ])

                                        @include('front.components.show-row', [
                                            'name'  => 'academy',
                                            'value' => $course->academy
                                        ])

                                        @include('front.components.show-row', [
                                            'name'  => 'website',
                                            'value' => $course->website
                                        ])

                                        @include('front.components.show-row', [
                                            'name'  => 'instructor',
                                            'value' => $course->instructor
                                        ])

                                        @include('front.components.show-row', [
                                            'name'  => 'description',
                                            'value' => $course->description
                                        ])

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    @include('front.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
