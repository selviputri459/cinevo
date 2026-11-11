@extends('layouts.user')

@section('title', 'Booking Tiket')

@push('styles')
<style>
    .booking-page {
        background: radial-gradient(circle at 50% -10%, rgba(232, 161, 196, 0.12) 0%, var(--cinevo-bg) 60%);
        color: var(--cinevo-text);
        border-radius: 18px;
        padding: 32px 24px 40px;
        font-family: 'Inter', sans-serif;
    }

    .booking-page h1 {
        text-align: center;
        font-weight: 600;
        margin-bottom: 28px;
        color: var(--cinevo-text);
    }

    .booking-layout {
        display: flex;
        gap: 28px;
        flex-wrap: wrap;
        justify-content: center;
        align-items: flex-start;
    }

    .booking-card {
        background: var(--cinevo-panel);
        border: 1px solid var(--cinevo-border);
        border-radius: 16px;
        padding: 24px;
        width: 360px;
    }

    .booking-card img {
        width: 100%;
        max-width: 160px;
        height: 235px;
        border-radius: 10px;
        display: block;
        margin: 0 auto 16px;
        object-fit: cover;
    }

    .booking-card dl {
        margin: 0;
    }

    .booking-card dt {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--cinevo-muted);
        margin-top: 14px;
    }

    .booking-card dt:first-of-type {
        margin-top: 0;
    }

    .booking-card dd {
        margin: 2px 0 0;
        font-weight: 600;
        color: var(--cinevo-text);
    }

    .booking-form {
        background: var(--cinevo-panel);
        border: 1px solid var(--cinevo-border);
        border-radius: 16px;
        padding: 24px;
        width: 360px;
    }

    .booking-form h3 {
        font-size: 1.05rem;
        font-weight: 600;
        margin: 0 0 16px;
        color: var(--cinevo-text);
    }

    .booking-form label {
        display: block;
        font-size: .8rem;
        color: var(--cinevo-muted);
        margin-bottom: 4px;
    }

    .booking-form .field {
        margin-bottom: 16px;
    }

    .booking-form input[readonly],
    .booking-form input[type="tel"] {
        width: 100%;
        padding: 9px 12px;
        border-radius: 8px;
        border: 1px solid var(--cinevo-border);
        background: rgba(255, 255, 255, .06);
        color: var(--cinevo-text);
        outline: none;
    }

    .booking-form input.is-invalid {
        border-color: #ff6b6b;
    }

    .booking-form .field-error {
        display: block;
        margin-top: 4px;
        font-size: .78rem;
        color: #ff6b6b;
    }

    .btn-booking {
        width: 100%;
        padding: 11px;
        border-radius: 9px;
        border: 1px solid var(--cinevo-pink);
        background: var(--cinevo-pink);
        color: var(--cinevo-bg-dark);
        font-weight: 700;
        cursor: pointer;
        margin-top: 6px;
        transition: .2s ease;
    }

    .btn-booking:hover {
        background: var(--cinevo-pink-light);
        border-color: var(--cinevo-pink-light);
        color: var(--cinevo-bg-dark);
    }
</style>
@endpush

@section('content')
<div class="booking-page">
    <h1>Booking Tiket</h1>

    <div class="booking-layout">
        <div class="booking-card">
            <img src="{{ $showtime->film->poster ? asset('storage/'.$showtime->film->poster) : 'https://placehold.co/160x220?text=Poster' }}"
                alt="{{ $showtime->film->title }}">

            <dl>
                <dt>Judul Film</dt>
                <dd>{{ $showtime->film->title }}</dd>

                <dt>Studio</dt>
                <dd>{{ $showtime->studio->name }}</dd>

                <dt>Tanggal - Jam</dt>
                <dd>
                    {{ \Carbon\Carbon::parse($showtime->date)->translatedFormat('d M Y') }},
                    {{ \Carbon\Carbon::parse($showtime->time)->format('H:i') }}
                </dd>

                <dt>Kursi</dt>
                <dd>{{ $seats->pluck('seat_name')->join(', ') }}</dd>

                <dt>Jumlah Tiket</dt>
                <dd>{{ $seats->count() }} tiket</dd>

                <dt>Total</dt>
                <dd>Rp{{ number_format($total, 0, ',', '.') }}</dd>
            </dl>
        </div>

        <form class="booking-form" action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h3>Data Pemesanan</h3>

            <div class="field">
                <label>Nama</label>
                <input type="text" value="{{ auth()->user()->name }}" readonly>
            </div>

            <div class="field">
                <label>Email</label>
                <input type="text" value="{{ auth()->user()->email }}" readonly>
            </div>

            <div class="field">
                <label for="phone">No. Telepon</label>

                @if (auth()->user()->phone)
                    <input type="text" id="phone" value="{{ auth()->user()->phone }}" readonly>
                @else
                    <input type="tel" id="phone" name="phone"
                        value="{{ old('phone') }}"
                        placeholder="08xxxxxxxxxx"
                        inputmode="numeric" required
                        class="@error('phone') is-invalid @enderror">

                    @error('phone')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                @endif
            </div>

             <div class="field">
                <label>Metode Pembayaran</label>
                <div class="pay-options">
                    <label class="pay-option">
                        <input type="radio" name="payment_method" value="cash"
                            {{ old('payment_method', 'cash') === 'cash' ? 'checked' : '' }}>
                        <span>Bayar di Kasir</span>
                    </label>
                    <label class="pay-option">
                        <input type="radio" name="payment_method" value="transfer"
                            {{ old('payment_method') === 'transfer' ? 'checked' : '' }}>
                        <span>Transfer</span>
                    </label>
                </div>
            </div>

            <div id="transferSection" style="display:none;">
                <div class="field">
                    <label for="payment_channel">Transfer ke</label>
                    <select id="payment_channel" name="payment_channel" class="form-input @error('payment_channel') is-invalid @enderror" required>
                        <option value="">-- Pilih Bank / E-Wallet --</option>
                        @foreach (config('payment.accounts') as $key => $acc)
                            <option value="{{ $key }}"
                                data-number="{{ $acc['number'] }}"
                                data-name="{{ $acc['name'] }}"
                                {{ old('payment_channel') === $key ? 'selected' : '' }}>
                                {{ $acc['label'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('payment_channel')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="account-info" id="accountInfo" style="display:none;">
                    <small>Transfer sejumlah</small>
                    <div><strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></div>
                    <small>ke rekening</small>
                    <div class="acc-number" id="accNumber"></div>
                    <small>a.n. <span id="accName"></span></small>
                </div>

                <div class="field">
                    <label for="sender_account">Rekening / No. DANA Pengirim</label>
                    <input type="text" id="sender_account" name="sender_account" class="form-input @error('sender_account') is-invalid @enderror"
                        value="{{ old('sender_account') }}"
                        placeholder="Contoh: Mandiri 1234567890 a.n. Budi" required>
                    <small style="color: var(--cinevo-muted); font-size:.75rem;">Dipakai untuk verifikasi dan tujuan refund jika booking dibatalkan.</small>
                    @error('sender_account')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field">
                    <label for="payment_proof">Bukti Transfer (JPG/PNG/JPEG, maks 2 MB)</label>
                    <input type="file" id="payment_proof" name="payment_proof" accept="image/png,image/jpeg,image/jpg"
                        class="form-input @error('payment_proof') is-invalid @enderror" required>
                    @error('payment_proof')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
            @foreach ($seats as $seat)
                <input type="hidden" name="seat_id[]" value="{{ $seat->id }}">
            @endforeach

            <button type="submit" class="btn-booking">Booking Tiket</button>
        </form>
    </div>
</div>

<script>
    (function () {
        const radios   = document.querySelectorAll('input[name="payment_method"]');
        const section  = document.getElementById('transferSection');
        const channel  = document.getElementById('payment_channel');
        const info     = document.getElementById('accountInfo');
        const accNum   = document.getElementById('accNumber');
        const accName  = document.getElementById('accName');

        function toggleTransfer() {
            const isTransfer = document.querySelector('input[name="payment_method"]:checked').value === 'transfer';
            section.style.display = isTransfer ? 'block' : 'none';
            section.querySelectorAll('input, select').forEach(el => el.disabled = !isTransfer);
        }

        function showAccount() {
            const opt = channel.options[channel.selectedIndex];
            if (opt && opt.value) {
                accNum.textContent  = opt.dataset.number;
                accName.textContent = opt.dataset.name;
                info.style.display  = 'block';
            } else {
                info.style.display = 'none';
            }
        }

        radios.forEach(r => r.addEventListener('change', toggleTransfer));
        channel.addEventListener('change', showAccount);

        toggleTransfer();
        showAccount();
    })();
</script>
@endsection