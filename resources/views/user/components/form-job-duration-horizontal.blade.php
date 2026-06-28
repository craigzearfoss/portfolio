@php
    use App\Models\Career\JobDurationType;
    use App\Models\Career\JobDurationUnit;

    $job_duration_type_id = $job_duration_type_id ?? '';
    $job_duration_length  = $job_duration_length ?? '';
    $job_duration_unit_id = $job_duration_unit_id ?? '';

    $class   = !empty($class) ? $class : '';
    if (!empty($style)) {
        $style = is_array($style) ? implode('; ', $style) . ';' : $style;
    } else {
        $style = '';
    }

    $durationTypeSelectList = view('user.components.form-select', [
        'name'     => 'job_duration_type_id',
        'label'    => '',
        'value'    => old('job_duration_type_id') ?? $job_duration_type_id,
        'required' => true,
        'list'     => new JobDurationType()->listOptions([], 'id', 'name', true),
        'message'  => $message ?? '',
        'style'    => [ 'width: 9rem'],
    ]);

    $durationUnitSelectList = view('user.components.form-select', [
        'name'     => 'job_duration_unit_id',
        'label'    => '',
        'value'    => old('job_duration_unit_id') ?? $job_duration_unit_id,
        'list'     => new JobDurationUnit()->listOptions([], 'id', 'name', true),
        'message'  => $message ?? '',
        'style'    => [ 'width: 7rem'],
    ])
@endphp

<div class="field is-horizontal">

    <div class="field-label">
        <label for="inputJob_duration_type_id" class="label">
            duration
        </label>
    </div>

    <div class="field-body">

        <div style="width: 8.8rem;">
            {!! $durationTypeSelectList !!}
        </div>

        <div id="durationLengthDiv" class="field mr-1" style="flex-grow: 0;{{ empty($job_duration_type_id) || ($job_duration_type_id == 2) ? 'display: none;' : '' }}">
            @include('user.components.input', [
                'id'      => 'job_duration_length',
                'name'    => 'job_duration_length',
                'value'   =>  $job_duration_length,
                'message' => $message ?? '',
                'class'   => [ 'input' ],
                'style'   => [ 'width: 4rem' ],
            ])
        </div>

        <div id="durationUnitId" {!! empty($job_duration_type_id) || ($job_duration_type_id == 2) ? 'style="display: none;"' : '' !!}>
            {!! $durationUnitSelectList !!}
        </div>

    </div>

</div>

<script>

    document.addEventListener('DOMContentLoaded', () => {

        document.getElementById('inputJob_duration_type_id').addEventListener('change', (event) => {

            const selectedValue = parseInt(event.target.value);

            if (selectedValue === 2) {
                document.getElementById('inputJob_duration_length').value = '';
                document.getElementById('inputJob_duration_unit_id').value = '';
                document.getElementById('durationLengthDiv').style.display = 'block';
                document.getElementById('durationUnitId').style.display = 'block';
            } else {
                document.getElementById('durationLengthDiv').style.display = 'none';
                document.getElementById('durationUnitId').style.display = 'none';
            }
        });
    });

</script>
