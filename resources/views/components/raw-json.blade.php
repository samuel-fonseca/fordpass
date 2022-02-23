<button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#raw-status-json" aria-expanded="false" aria-controls="raw-status-json">
    Raw JSON
</button>
<div class="mt-4"></div>
<div class="collapse" id="raw-status-json">
    <div class="bg-light border rounded p-2">
        <pre><code>{{ json_encode($data, JSON_PRETTY_PRINT) }}</code></pre>
    </div>
</div>
