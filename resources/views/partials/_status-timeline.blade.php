@php
    // build ordered list of steps
    $steps = [];
    $steps[] = ['label' => 'Dikirim', 'time' => $laporan->created_at];
    foreach ($timeline ?? [] as $h) {
        $steps[] = ['label' => $h->event, 'time' => $h->created_at];
    }
    // append selesai if there are history events and the last label is not already "Selesai"
    if (count($timeline ?? []) && strtolower(end($steps)['label']) !== 'selesai') {
        $steps[] = ['label' => 'Selesai', 'time' => end($steps)['time']];
    }
@endphp

<div class="status-timeline">
    @foreach ($steps as $step)
        <div class="status-item {{ $step['time'] ? 'active' : '' }}">
            <div class="circle">
                @if($step['time'])<i class="bi bi-check-lg"></i>@endif
            </div>
            <div class="label">{{ $step['label'] }}</div>
            @if ($step['time'])
                <div class="time">{{ \Carbon\Carbon::parse($step['time'])->format('d M Y H:i') }}</div>
            @endif
        </div>
    @endforeach
</div>
