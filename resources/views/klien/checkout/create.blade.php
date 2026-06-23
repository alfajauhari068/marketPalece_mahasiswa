@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="mb-4">
        <a href="{{ route('services.show', $service->id) }}" class="text-decoration-none text-primary">
            <i class="bi bi-chevron-left"></i> Kembali ke Detail Layanan
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <form action="{{ route('checkout.store', $service->id) }}" method="POST">
                @csrf
                <div class="card rounded-4 shadow-sm p-4">
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-3">Checkout</span>
                    <h1 class="h3 fw-bold mb-3">Pesan layanan ini</h1>
                    
                    <!-- Service Preview -->
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <img src="{{ $service->primary_image ?? asset('images/no-image.png') }}"
                             alt="{{ $service->title }}"
                             class="rounded-4"
                             style="width: 110px; height: 110px; object-fit: cover;" />
                        <div>
                            <p class="text-muted mb-1">{{ $service->category?->name ?? 'Kategori' }}</p>
                            <h2 class="h5 fw-semibold mb-1">{{ $service->title }}</h2>
                            <p class="text-muted mb-0">By {{ $service->user?->name ?? 'Freelancer' }}</p>
                        </div>
                    </div>

                    <p class="text-muted mb-4">{{ $service->description }}</p>

                    <!-- Seller Info -->
                    <div class="p-4 bg-light rounded-4 mb-4">
                        <h3 class="h6 fw-semibold mb-3">Informasi Seller</h3>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $service->user?->profile?->photo ?? asset('images/default-avatar.png') }}"
                                 alt="{{ $service->user?->name }}"
                                 class="rounded-circle"
                                 style="width: 50px; height: 50px; object-fit: cover;" />
                            <div>
                                <p class="mb-0 fw-semibold">{{ $service->user?->name ?? 'N/A' }}</p>
                                <p class="mb-0 text-muted small">Rating: {{ $service->user?->profile?->rating_avg ?? '0' }}/5</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Service Price Info -->
                    <div class="row row-cols-2 g-3 mb-4">
                        <div class="col">
                            <div class="p-3 rounded-4 bg-light">
                                <small class="text-muted">Harga per unit</small>
                                <div class="fw-semibold">Rp {{ number_format($service->price ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3 rounded-4 bg-light">
                                <small class="text-muted">Kategori</small>
                                <div class="fw-semibold">{{ $service->category?->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Quantity Input -->
                    <div class="mb-4">
                        <label for="quantity" class="form-label fw-semibold">Jumlah</label>
                        <input type="number" 
                               class="form-control form-control-lg rounded-3 @error('quantity') is-invalid @enderror" 
                               id="quantity" 
                               name="quantity" 
                               value="{{ old('quantity', 1) }}" 
                               min="1" 
                               max="1000"
                               required
                               onchange="updateTotal()">
                        @error('quantity')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Notes Textarea -->
                    <div class="mb-4">
                        <label for="notes" class="form-label fw-semibold">Catatan/Persyaratan Proyek</label>
                        <textarea class="form-control rounded-3 @error('notes') is-invalid @enderror" 
                                  id="notes" 
                                  name="notes" 
                                  rows="4"
                                  placeholder="Masukkan detail proyek, persyaratan khusus, atau instruksi apapun..."
                                  maxlength="1000">{{ old('notes') }}</textarea>
                        <small class="text-muted">Opsional - Maksimal 1000 karakter</small>
                        @error('notes')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Total yang harus dibayar</div>
                            <div class="fs-4 fw-bold text-primary">
                                Rp <span id="total">{{ number_format($service->price ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">
                            <i class="bi bi-check-circle"></i> Lanjutkan ke Pembayaran
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="card rounded-4 shadow-sm p-4 position-sticky" style="top: 20px;">
                <h2 class="h6 fw-semibold mb-3">Ringkasan Pesanan</h2>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Layanan</span>
                        <span>{{ $service->title }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Harga per unit</span>
                        <span>Rp {{ number_format($service->price ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Jumlah</span>
                        <span id="quantity-display">1</span>
                    </div>
                </div>

                <hr />

                <div class="d-flex justify-content-between fw-semibold mb-3">
                    <span>Subtotal</span>
                    <span>Rp <span id="subtotal">{{ number_format($service->price ?? 0, 0, ',', '.') }}</span></span>
                </div>

                <div class="p-3 bg-light rounded-3 mb-3">
                    <small class="text-muted">Biaya Layanan</small>
                    <div class="fw-semibold">Gratis</div>
                </div>

                <hr />

                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span class="text-primary">Rp <span id="final-total">{{ number_format($service->price ?? 0, 0, ',', '.') }}</span></span>
                </div>

                <div class="alert alert-info alert-sm rounded-3 mt-3 mb-0">
                    <small><i class="bi bi-info-circle"></i> Pembayaran dapat dilakukan melalui QRIS, Transfer Bank, atau E-wallet</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const servicePrice = {{ $service->price ?? 0 }};

function updateTotal() {
    const quantityInput = document.getElementById('quantity');
    const quantity = parseInt(quantityInput.value) || 1;
    
    // Ensure quantity is at least 1
    if (quantity < 1) {
        quantityInput.value = 1;
    }
    
    const subtotal = servicePrice * quantity;
    const total = subtotal; // No additional fees
    
    // Update display
    document.getElementById('quantity-display').textContent = quantity;
    document.getElementById('subtotal').textContent = formatCurrency(subtotal);
    document.getElementById('total').textContent = formatCurrency(total);
    document.getElementById('final-total').textContent = formatCurrency(total);
}

function formatCurrency(amount) {
    return amount.toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', updateTotal);
document.getElementById('quantity').addEventListener('change', updateTotal);
document.getElementById('quantity').addEventListener('input', updateTotal);
</script>
@endsection
