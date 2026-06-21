<div class="card rounded-4 shadow-sm p-4 h-100 bg-white">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="text-muted small">{{ $stat['label'] }}</div>
        <div class="icon-circle bg-primary bg-opacity-10 text-primary rounded-3 d-inline-flex align-items-center justify-content-center" style="width:38px;height:38px;">
            <i class="bi {{ $stat['icon'] }} fs-5"></i>
        </div>
    </div>
    <h3 class="fw-bold mb-2">{{ $stat['value'] }}</h3>
    <p class="text-muted small mb-0">{{ $stat['detail'] }}</p>
</div>
