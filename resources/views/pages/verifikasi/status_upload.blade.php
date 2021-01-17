@php
    $count = 0;
    if ($data->pembayaran != NULL) {
       $count = $count + 1;
    }

    if ($data->lppm != NULL) {
        $count = $count + 1;
    }

    if ($data->perpus != NULL) {
        $count = $count + 1;
    }

    $val = $count / 3;
    $percent = $val * 100; 

@endphp

<div class="progress">
    <div class="progress-bar" role="progressbar" style="width: {{$percent}}%;" aria-valuenow="{{$percent}}" aria-valuemin="0" aria-valuemax="100">{{$count}}/3</div>
</div> 
