@php
$key = rand();
@endphp
<div>
    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#rawJsonModal-{{$key}}">
        {{ $title ?? 'Raw JSON' }}
    </button>
    <div class="modal fade" tabindex="-1" id="rawJsonModal-{{$key}}">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title ?? 'Raw JSON' }} Output</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light">
                    <pre><code>{{ json_encode($data, JSON_PRETTY_PRINT) }}</code></pre>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
