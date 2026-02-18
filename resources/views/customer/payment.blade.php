@extends('layouts.dashboard-layout')

@section('title', 'Pembayaran Upgrade - MaticPost')

@section('content')
    <div class="max-w-md mx-auto">
        <a href="{{ route('dashboard.upgrade') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-brand-600 mb-6 transition">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-8 text-center">
            <div class="mb-6">
                <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-credit-card text-brand-600 text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 mb-2">Upgrade Pembayaran</h1>
                <p class="text-slate-500">
                    Upgrade ke paket <strong>{{ ucfirst($newPlan) }}</strong>
                </p>
            </div>

            <div class="bg-slate-50 rounded-xl p-4 mb-8 text-left">
                <div class="flex justify-between mb-2">
                    <span class="text-slate-500 text-sm">Order ID</span>
                    <span class="font-mono text-slate-700 text-sm">{{ $subscription->midtrans_order_id }}</span>
                </div>
                <div class="flex justify-between font-bold text-slate-800">
                    <span>Total</span>
                    <span>Rp {{ number_format($subscription->amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <button id="pay-button" class="w-full bg-gradient-to-r from-brand-600 to-accent-500 hover:from-brand-700 hover:to-accent-600 text-white font-bold py-3 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                Bayar Sekarang
            </button>

            <p class="text-xs text-slate-400 mt-6">
                Pembayaran diproses aman oleh Midtrans.
            </p>
        </div>
    </div>
@endsection

@push('scripts')
{{-- Midtrans Snap JS --}}
<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                window.location.href = "{{ route('payment.status') }}?status=success&order_id={{ $subscription->midtrans_order_id }}";
            },
            onPending: function(result){
                window.location.href = "{{ route('payment.status') }}?status=pending&order_id={{ $subscription->midtrans_order_id }}";
            },
            onError: function(result){
                window.location.href = "{{ route('payment.status') }}?status=error&order_id={{ $subscription->midtrans_order_id }}";
            },
            onClose: function(){
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    };
</script>
@endpush
