@php

    use App\Models\Career\JobBoard;

    $job_board_id  = $job_board_id ?? null;
    $job_board_id2 = $job_board_id2 ?? null;

    $horizontal = $horizontal ?? true;

    $class   = !empty($class) ? $class : '';
    if (!empty($style)) {
        $style = is_array($style) ? implode('; ', $style) . ';' : $style;
    } else {
        $style = '';
    }

    $jobListOptions = new JobBoard()->listOptions([], 'id', 'name', true);
@endphp
<div class="field is-horizontal">
    <div class="field-label">
        <label class="label" for="inputStreet">{!! $label ?? 'job board(s)' !!}</label>
    </div>
    <div class="field-body{{ !$horizontal ? ' not-horizontal' : '' }}" >

        <div class="mr-21">
            <div class="select mb-1">
                @include('guest.components.select-list', [
                    'name'    => 'job_board_id',
                    'label'   => 'job board',
                    'value'   => $job_board_id,
                    'list'    => $jobListOptions,
                    'style'   => [ 'display: inline-block' ],
                    'message' => $message ?? '',
                ])
            </div>

            <br>

            <div class="select" >
                @include('guest.components.select-list', [
                    'name'    => 'job_board_id2',
                    'label'   => 'job board 2',
                    'value'   => $job_board_id2,
                    'list'    => $jobListOptions,
                    'style'   => [ 'display: inline-block'],
                    'message' => $message ?? '',
                ])
            </div>
        </div>

        @error('job_board_id')
            <p class="help is-danger">{!! $message ?? '' !!}</p>
        @enderror

        @error('job_board_id2')
            <p class="help is-danger">{!! $message ?? '' !!}</p>
        @enderror

    </div>
</div>
