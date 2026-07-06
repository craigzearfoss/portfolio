<a class = "button is-primary modal-button" data-modal-id="add-comment-modal" data-target="#modal">Add a comment.</a>

<div id="add-comment-modal" class="modal">

    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Add a Comment</p>
            <button class="delete" aria-label="close"></button>
        </header>

        <section class="modal-card-body">

            <form action="{{ route('api.v1.comment.store') }}"
                  method="POST"
            >
                @csrf

                @include('guest.components.form-hidden', [
                    'name'  => 'class',
                    'value' => $resource->connection . '.' .  $resource->table
                ])

                @include('guest.components.form-hidden', [
                    'name'  => 'id',
                    'value' => $resource->id

                ])


                <div class="content">
                    @include('guest.components.form-textarea', [
                        'cols' => 60,
                        'rows' => 50,
                    ])
                    <div class="has-text-right">
                        @include('guest.components.form-button-submit-horizontal')
                    </div>
                </div>

            </form>

        </section>

    </div>
</div>
