@extends('layouts.app')

@section('title', 'Pilih Kursi')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    :root{
        --kursi-bg-start: #7A1B4F;
        --kursi-bg-end: #35081F;
        --kursi-panel: #4F1236;
        --kursi-border: rgba(255,255,255,.12);
        --kursi-text: #FBEFF4;
        --kursi-muted: #D79BB8;
        --kursi-accent: #F2A6C6;
        --kursi-accent-soft: rgba(242,166,198,.18);
        --kursi-booked: #7A3E5C;
    }

    .kursi-page{
        background: radial-gradient(circle at 50% -10%, var(--kursi-bg-start) 0%, var(--kursi-bg-end) 60%);
        color: var(--kursi-text);
        font-family: 'Inter', sans-serif;
        border-radius: 18px;
        padding: 32px 24px 40px;
    }

    .kursi-header{
        text-align:center;
        margin-bottom: 28px;
    }
    .kursi-header h1{
        font-family:'Fraunces', serif;
        font-weight:600;
        font-size: 1.6rem;
        margin: 0 0 6px;
    }
    .kursi-header__meta{
        color: var(--kursi-muted);
        font-size: .92rem;
    }
    .kursi-header__meta .dot{ margin: 0 8px; opacity:.5; }

    .kursi-legend{
        display:flex;
        justify-content:center;
        gap: 28px;
        margin-bottom: 30px;
        font-size: .85rem;
        color: var(--kursi-muted);
    }
    .kursi-legend span{ display:flex; align-items:center; gap:8px; }
    .legend-box{ width:16px; height:16px; border-radius:4px; display:inline-block; }
    .legend-box.available{ border:1.5px solid var(--kursi-accent); background:transparent; }
    .legend-box.booked{ background: var(--kursi-booked); }
    .legend-box.selected{ background: var(--kursi-accent); }

    .kursi-layout{
        display:flex;
        gap: 32px;
        flex-wrap: wrap;
        align-items:flex-start;
        justify-content:center;
    }

    .screen-wrap{ text-align:center; margin-bottom: 26px; }
    .screen-arc{
        width: min(560px, 90%);
        height: 14px;
        margin: 0 auto 10px;
        border-radius: 0 0 60px 60px / 0 0 40px 40px;
        background: linear-gradient(180deg, rgba(212,175,55,.55), transparent);
        box-shadow: 0 10px 30px -6px rgba(212,175,55,.45);
    }
    .screen-arc + span{
        display:block;
        letter-spacing: .3em;
        font-size: .72rem;
        color: var(--kursi-muted);
        text-transform: uppercase;
    }

    .kursi-blocks{ display:flex; flex-direction:column; gap:10px; }
    .kursi-row{ display:flex; align-items:center; gap: 14px; }
    .row-label{
        width: 18px;
        text-align:center;
        font-size:.8rem;
        color: var(--kursi-muted);
    }
    .block{ display:flex; gap: 8px; }
    .aisle{ width: 26px; }

    .seat{
        width: 34px;
        height: 34px;
        border-radius: 8px;
        font-size: .72rem;
        font-weight: 600;
        display:flex;
        align-items:center;
        justify-content:center;
        cursor:pointer;
        border: 1.5px solid var(--kursi-accent);
        background: transparent;
        color: var(--kursi-text);
        transition: transform .12s ease, background .12s ease;
    }
    .seat:hover:not(:disabled){ transform: translateY(-2px); background: var(--kursi-accent-soft); }
    .seat--booked{
        border-color: var(--kursi-booked);
        background: var(--kursi-booked);
        color: #6D7178;
        cursor:not-allowed;
    }
    .seat--booked:hover{ transform:none; }
    .seat--selected{
        background: var(--kursi-accent);
        border-color: var(--kursi-accent);
        color: #3B0A28;
    }

    .kursi-summary{
        width: 260px;
        background: var(--kursi-panel);
        border: 1px solid var(--kursi-border);
        border-radius: 14px;
        padding: 20px;
        position: sticky;
        top: 20px;
    }
    .kursi-summary h3{
        font-family:'Fraunces', serif;
        font-size: 1.05rem;
        margin: 0 0 14px;
        font-weight: 600;
    }
    .selected-list{
        list-style:none;
        margin:0 0 18px;
        padding:0;
        max-height: 180px;
        overflow-y:auto;
    }
    .selected-list li{
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding: 8px 10px;
        border: 1px solid var(--kursi-border);
        border-radius: 8px;
        margin-bottom: 6px;
        font-size: .88rem;
    }
    .selected-list li button{
        background:none;
        border:none;
        color: var(--kursi-muted);
        cursor:pointer;
        font-size: .95rem;
        line-height:1;
    }
    .selected-list li button:hover{ color: var(--kursi-text); }
    .selected-list .empty{
        color: var(--kursi-muted);
        border-style: dashed;
        justify-content:center;
    }

    .summary-total{
        display:flex;
        justify-content:space-between;
        align-items:baseline;
        padding-top: 14px;
        margin-top: 4px;
        border-top: 1px solid var(--kursi-border);
        margin-bottom: 18px;
    }
    .summary-total span:first-child{ color: var(--kursi-muted); font-size:.85rem; }
    .summary-total span:last-child{ font-family:'Fraunces', serif; font-size:1.15rem; }

    .btn-lanjut{
        width:100%;
        padding: 11px;
        border-radius: 9px;
        border: none;
        background: var(--kursi-accent);
        color: #3B0A28;
        font-weight:600;
        cursor:pointer;
        transition: opacity .15s ease;
    }
    .btn-lanjut:disabled{ opacity:.4; cursor:not-allowed; }

    @media (max-width: 720px){
        .seat{ width: 28px; height: 28px; font-size: .64rem; }
        .kursi-summary{ position:static; width:100%; }
    }
</style>
@endpush

@section('content')
<div class="kursi-page">

    <div class="kursi-header">
        <h1>Pilih Kursi</h1>
        <div class="kursi-header__meta">
            <span>{{ $showtime->film->title }}</span>
            <span class="dot">&bull;</span>
            <span>{{ $showtime->studio->name }}</span>
            <span class="dot">&bull;</span>
            <span>
                {{ \Carbon\Carbon::parse($showtime->date)->translatedFormat('d M Y') }},
                {{ \Carbon\Carbon::parse($showtime->time)->format('H:i') }}
            </span>
        </div>
    </div>

    <div class="kursi-legend">
        <span><i class="legend-box available"></i> Available</span>
        <span><i class="legend-box booked"></i> Booked</span>
        <span><i class="legend-box selected"></i> Selected</span>
    </div>

    <div class="kursi-layout">
        <div style="flex:1; min-width:280px; display:flex; flex-direction:column; align-items:center;">
            <div class="screen-wrap">
                <div class="screen-arc"></div>
                <span>Layar</span>
            </div>

            <div class="kursi-blocks">
                @foreach($seatRows as $baris => $blocks)
                    <div class="kursi-row">
                        <span class="row-label">{{ $baris }}</span>

                        <div class="block">
                            @foreach($blocks->get(0, collect()) as $seat)
                                @php $isBooked = in_array($seat->id, $bookedSeatIds); @endphp
                                <button
                                    type="button"
                                    class="seat {{ $isBooked ? 'seat--booked' : '' }}"
                                    data-id="{{ $seat->id }}"
                                    data-nomor="{{ $seat->seat_name }}"
                                    {{ $isBooked ? 'disabled' : '' }}
                                >{{ $seat->seat_name }}</button>
                            @endforeach
                        </div>

                        <div class="aisle"></div>

                        <div class="block">
                            @foreach($blocks->get(1, collect()) as $seat)
                                @php $isBooked = in_array($seat->id, $bookedSeatIds); @endphp
                                <button
                                    type="button"
                                    class="seat {{ $isBooked ? 'seat--booked' : '' }}"
                                    data-id="{{ $seat->id }}"
                                    data-nomor="{{ $seat->seat_name }}"
                                    {{ $isBooked ? 'disabled' : '' }}
                                >{{ $seat->seat_name }}</button>
                            @endforeach
                        </div>

                        <span class="row-label">{{ $baris }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <aside class="kursi-summary">
            <h3>Kursi Terpilih</h3>

            <ul id="selectedSeatList" class="selected-list">
                <li class="empty" id="emptyState">Belum ada kursi dipilih</li>
            </ul>

            <div class="summary-total">
                <span>Total</span>
                <span id="totalHarga">Rp 0</span>
            </div>

            <form id="kursiForm" action="{{ route('user.booking.store') }}" method="POST">
                @csrf
                <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
                <div id="hiddenKursiInputs"></div>
                <button type="submit" id="btnLanjut" class="btn-lanjut" disabled>Lanjutkan</button>
            </form>
        </aside>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const hargaTiket = {{ (float) $showtime->price }};
    const seatButtons = document.querySelectorAll('.seat:not(.seat--booked)');
    const selectedList = document.getElementById('selectedSeatList');
    const emptyState = document.getElementById('emptyState');
    const totalHarga = document.getElementById('totalHarga');
    const btnLanjut = document.getElementById('btnLanjut');
    const hiddenKursiInputs = document.getElementById('hiddenKursiInputs');

    let selectedSeats = [];

    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    function render() {
        selectedList.querySelectorAll('li:not(#emptyState)').forEach(li => li.remove());
        hiddenKursiInputs.innerHTML = '';

        if (selectedSeats.length === 0) {
            emptyState.style.display = 'flex';
        } else {
            emptyState.style.display = 'none';
            selectedSeats.forEach(seat => {
                const li = document.createElement('li');
                li.innerHTML = `<span>${seat.nomor}</span><button type="button" data-id="${seat.id}">&times;</button>`;
                selectedList.appendChild(li);

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'seat_id[]';
                input.value = seat.id;
                hiddenKursiInputs.appendChild(input);
            });
        }

        totalHarga.textContent = formatRupiah(selectedSeats.length * hargaTiket);
        btnLanjut.disabled = selectedSeats.length === 0;
    }

    function toggleSeat(button) {
        const id = button.dataset.id;
        const nomor = button.dataset.nomor;
        const idx = selectedSeats.findIndex(s => s.id === id);

        if (idx > -1) {
            selectedSeats.splice(idx, 1);
            button.classList.remove('seat--selected');
        } else {
            selectedSeats.push({ id, nomor });
            button.classList.add('seat--selected');
        }
        render();
    }

    seatButtons.forEach(button => {
        button.addEventListener('click', () => toggleSeat(button));
    });

    selectedList.addEventListener('click', (e) => {
        const removeBtn = e.target.closest('button[data-id]');
        if (!removeBtn) return;
        const id = removeBtn.dataset.id;
        const seatButton = document.querySelector(`.seat[data-id="${id}"]`);
        if (seatButton) seatButton.classList.remove('seat--selected');
        selectedSeats = selectedSeats.filter(s => s.id !== id);
        render();
    });

    render();
})();
</script>
@endpush