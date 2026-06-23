@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="mb-4">
        <a href="{{ route('checkout.create', $order->service_id) }}" class="text-decoration-none text-primary">
            <i class="bi bi-chevron-left"></i> Kembali ke Checkout
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card rounded-4 shadow-sm p-4">
                <span class="badge bg-warning bg-opacity-10 text-warning mb-3">Pembayaran</span>
                <h1 class="h3 fw-bold mb-4">Pilih Metode Pembayaran</h1>

                <!-- Payment Methods -->
                <form action="{{ route('payment.process', $order->id) }}" method="POST" id="payment-form">
                    @csrf
                    
                    <!-- QRIS Payment Method -->
                    <div class="payment-method mb-3">
                        <label class="payment-option p-4 rounded-4 border-2 cursor-pointer" style="border: 2px solid #e9ecef; transition: all 0.3s;">
                            <input type="radio" name="payment_method" value="qris" class="form-check-input payment-radio" required>
                            <div class="ms-3">
                                <h5 class="fw-bold mb-1">
                                    <i class="bi bi-qr-code"></i> QRIS
                                </h5>
                                <p class="text-muted mb-0 small">Scan kode QR untuk melakukan pembayaran</p>
                            </div>
                        </label>
                    </div>

                    <!-- Bank Transfer Payment Method -->
                    <div class="payment-method mb-3">
                        <label class="payment-option p-4 rounded-4 border-2 cursor-pointer" style="border: 2px solid #e9ecef; transition: all 0.3s;">
                            <input type="radio" name="payment_method" value="bank_transfer" class="form-check-input payment-radio" required>
                            <div class="ms-3">
                                <h5 class="fw-bold mb-1">
                                    <i class="bi bi-bank"></i> Transfer Bank
                                </h5>
                                <p class="text-muted mb-0 small">Transfer ke rekening kami via berbagai bank</p>
                            </div>
                        </label>
                    </div>

                    <!-- E-wallet Payment Method -->
                    <div class="payment-method mb-4">
                        <label class="payment-option p-4 rounded-4 border-2 cursor-pointer" style="border: 2px solid #e9ecef; transition: all 0.3s;">
                            <input type="radio" name="payment_method" value="e_wallet" class="form-check-input payment-radio" required>
                            <div class="ms-3">
                                <h5 class="fw-bold mb-1">
                                    <i class="bi bi-wallet2"></i> E-wallet
                                </h5>
                                <p class="text-muted mb-0 small">GoPay, OVO, DANA, LinkAja, dan lainnya</p>
                            </div>
                        </label>
                    </div>

                    <hr>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 flex-grow-1">
                            <i class="bi bi-credit-card"></i> Proses Pembayaran
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-lg rounded-pill px-5" onclick="testPayment(true)">
                            <i class="bi bi-check-circle"></i> Test Success
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-lg rounded-pill px-5" onclick="testPayment(false)">
                            <i class="bi bi-x-circle"></i> Test Fail
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="col-lg-4">
            <div class="card rounded-4 shadow-sm p-4 position-sticky" style="top: 20px;">
                <h2 class="h6 fw-semibold mb-3">Ringkasan Pesanan</h2>
                
                <!-- Service Info -->
                <div class="mb-3">
                    <p class="text-muted small mb-1">Layanan</p>
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ $order->service->primary_image ?? asset('images/no-image.png') }}"
                             alt="{{ $order->service->title }}"
                             class="rounded-2"
                             style="width: 40px; height: 40px; object-fit: cover;" />
                        <div style="flex: 1;">
                            <p class="mb-0 fw-semibold small">{{ $order->service->title }}</p>
                            <p class="mb-0 text-muted small">{{ $order->service->user->name }}</p>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Order Details -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Harga per unit</span>
                        <span class="fw-semibold small">Rp {{ number_format($order->service->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Jumlah</span>
                        <span class="fw-semibold small">{{ $order->quantity }} unit</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Subtotal</span>
                        <span class="fw-semibold small">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between fw-bold">
                    <span>Total Pembayaran</span>
                    <span class="text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>

                <!-- Order Notes if any -->
                @if($order->orderDetail && $order->orderDetail->note)
                    <hr>
                    <div class="mt-3">
                        <p class="text-muted small mb-1">Catatan Pesanan</p>
                        <p class="bg-light p-3 rounded-3 small mb-0">{{ $order->orderDetail->note }}</p>
                    </div>
                @endif

                <!-- Order Code -->
                <hr>
                <div class="text-center">
                    <p class="text-muted small mb-1">Nomor Pesanan</p>
                    <p class="fw-bold text-monospace">{{ $order->order_code }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.payment-option {
    display: flex;
    align-items: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.payment-option:hover {
    background-color: #f8f9fa;
    border-color: #0d6efd !important;
}

.payment-radio:checked {
    accent-color: #0d6efd;
}

.payment-method input[type="radio"]:checked ~ label,
.payment-option:has(input[type="radio"]:checked) {
    border-color: #0d6efd !important;
    background-color: #f0f7ff;
}

.cursor-pointer {
    cursor: pointer;
}
</style>

<script>
function testPayment(isSuccess) {
    const form = document.getElementById('payment-form');
    const method = document.querySelector('input[name="payment_method"]:checked');
    
    if (!method) {
        alert('Pilih metode pembayaran terlebih dahulu');
        return;
    }
    
    // Create hidden input for test
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = isSuccess ? '_simulate_success' : '_simulate_failure';
    input.value = 'true';
    form.appendChild(input);
    
    form.submit();
}

// Update radio button styling when changed
document.querySelectorAll('.payment-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.payment-option').forEach(opt => {
            opt.style.borderColor = '#e9ecef';
            opt.style.backgroundColor = 'white';
        });
        
        this.closest('.payment-option').style.borderColor = '#0d6efd';
        this.closest('.payment-option').style.backgroundColor = '#f0f7ff';
    });
});
</script>
@endsection
