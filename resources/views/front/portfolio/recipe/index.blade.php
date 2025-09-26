@extends('front.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('front.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('front.components.header')

                @include('front.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Recipes</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('front.components.messages', [$errors])
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th>name</th>
                            <th>featured</th>
                            <th>description</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($recipes as $recipe)

                            <tr>
                                <td>
                                    @include('front.components.link', [
                                        'name'   => $recipe->name,
                                        'url'    => route('front.portfolio.recipe.show', $recipe->slug)
                                    ])
                                </td>
                                <td class="has-text-centered">
                                    @include('front.components.checkmark', [ 'checked' => $recipe->featured ])
                                </td>
                                <td>
                                    {!! nl2br($recipe->description ?? '') !!}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="5">There are no recipes.</td>
                            </tr>

                        @endforelse

                        </tbody>
                    </table>

                    {!! $recipes->links() !!}

                    @include('front.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
