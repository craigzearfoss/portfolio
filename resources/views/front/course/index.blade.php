@extends('front.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('front.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('front.components.header')

                @include('front.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Courses</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('front.components.messages', [$errors])
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th>name</th>
                            <th class="has-text-centered">featured</th>
                            <th class="has-text-centered">professional</th>
                            <th class="has-text-centered">personal</th>
                            <th>completed</th>
                            <th>academy</th>
                            <th>instructor</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($courses as $course)

                            <tr>
                                <td>
                                    @include('front.components.link', [
                                        'name'   => $course->name,
                                        'url'    => route('front.course.show', $course->slug)
                                    ])
                                </td>
                                <td class="has-text-centered">
                                    @include('front.components.checkmark', [ 'checked' => $course->featured ])
                                </td>
                                <td class="has-text-centered">
                                    @include('front.components.checkmark', [ 'checked' => $course->professional ])
                                </td>
                                <td class="has-text-centered">
                                    @include('front.components.checkmark', [ 'checked' => $course->personal ])
                                </td>
                                <td>
                                    {{ shortDate($course->completed) }}
                                </td>
                                <td>
                                    {{ $course->academy }}
                                </td>
                                <td>
                                    {{ $course->instructor }}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7">There are no courses.</td>
                            </tr>

                        @endforelse

                        </tbody>
                    </table>

                    {!! $courses->links() !!}

                    @include('front.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
