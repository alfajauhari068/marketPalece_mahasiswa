<div class="card rounded-4 shadow-sm h-100 bg-white order-card">
    <div class="row g-0 h-100">
        <div class="col-4">
            <img src="{{ $order['image'] ?? 'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=320&q=80' }}" alt="{{ $order['title'] }}" class="img-fluid rounded-start-4 h-100 object-cover" />
        </div>
        <div class="col-8">
            <div class="card-body d-flex flex-column h-100">
                <h5 class="card-title mb-2">{{ $order['title'] }}</h5>
                <p class="text-muted small mb-2">Seller: {{ $order['seller'] }}</p>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="badge bg-{{ $order['badge'] ?? 'secondary' }} bg-opacity-10 text-{{ $order['badge'] ?? 'secondary' }}">{{ $order['status'] }}</span>
                    <span class="text-muted small">{{ $order['date'] }}</span>
                </div>
                <div class="mt-auto d-flex align-items-center justify-content-between">
                    <div class="fw-semibold text-primary">{{ $order['price'] }}</div>
                    <a href="{{ $detailRoute }}" class="btn btn-sm btn-outline-primary rounded-pill">View</a>
                </div>
            </div>
        </div>
    </div>
</div>
