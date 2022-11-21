<div class="progress">
    <div
        class="progress-bar {{ $progress >= 50 ? 'bg-success' : 'bg-warning' }}"
        role="progressbar"
        style="width: {{ $progress ?? 0 }}%"
        aria-valuenow="0"
        aria-valuemin="0"
        aria-valuemax="100"
    >
        {!! $content ?? null !!}
    </div>
</div>
