<footer class="user-footer mt-auto">

    <div class="footer-accent"></div>

    <div class="container py-5">
        <div class="row gy-4">

            <div class="col-lg-5 col-md-6 text-center text-md-start">
                <div class="footer-brand mb-2">
                    <img src="{{ asset('img/logo.png') }}" alt="Cinevo" class="cinevo-logo me-2">Cinevo
                </div>
                <p class="footer-desc mb-3">
                    Pesan tiket bioskop jadi lebih mudah. Pilih film, tentukan jadwal,
                    pilih kursi favoritmu, dan nikmati tontonan tanpa antre panjang.
                </p>

                <div class="footer-social">
                    <a href="https://www.instagram.com/selviptri.s_?mdxt=dXFibm1rdDJ5c3Zy" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.tiktok.com/@slviptri_09?_r=1&_t=ZS-9AuBYUvnD2S" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="https://wa.me/6285601516139" target="_blank" rel="noopener" aria-label="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-6 text-md-start">
                <h6 class="footer-title">Menu</h6>
                <ul class="footer-links list-unstyled mb-0">
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    @auth
                        <li><a href="{{ route('booking.index') }}">Riwayat Booking</a></li>
                        <li><a href="{{ route('profile') }}">Profil Saya</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Masuk</a></li>
                        <li><a href="{{ route('register') }}">Daftar</a></li>
                    @endauth
                </ul>
            </div>

            <div class="col-lg-4 col-md-12 text-center text-md-start">
                <h6 class="footer-title">Butuh Bantuan?</h6>
                <p class="footer-desc mb-3">
                    Ada pertanyaan soal booking atau pembayaran? Hubungi admin kami.
                </p>
                <a href="https://wa.me/6285601516139?text=Halo%20admin%20Cinevo%2C%20saya%20mau%20bertanya"
                   target="_blank" rel="noopener" class="btn-wa">
                    <i class="fab fa-whatsapp me-2"></i>0856-0151-6139
                </a>
            </div>

        </div>

        <hr class="footer-line my-4">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <small>&copy; {{ date('Y') }} Cinevo. All rights reserved.</small>
            <button type="button" class="btn-top" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })">
                Kembali ke atas <i class="fas fa-arrow-up ms-1"></i>
            </button>
        </div>
    </div>
</footer>

<style>
    body { min-height: 100vh; display: flex; flex-direction: column; }

    .user-footer {
        background: linear-gradient(90deg, #77254e, #58072d); /* latar tetap sama seperti punyamu */
        color: #fff;
    }

    .footer-accent {
        height: 4px;
        background: linear-gradient(90deg, #7c3aed, #e11d48);
    }

    .footer-brand {
        font-size: 1.6rem;
        font-weight: 700;
        letter-spacing: .5px;
    }

    .footer-desc {
        font-size: .9rem;
        opacity: .85;
        line-height: 1.6;
    }

    .footer-title {
        text-transform: uppercase;
        font-size: .85rem;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 1rem;
        padding-bottom: .5rem;
        position: relative;
    }
    .footer-title::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 32px;
        height: 3px;
        border-radius: 2px;
        background: #e11d48;
    }
    @media (max-width: 767.98px) {
        .footer-title::after { left: 50%; transform: translateX(-50%); }
        .footer-title, .footer-links, .footer-steps { text-align: center; }
        .footer-steps { list-style-position: inside; padding-left: 0; }
    }

    .user-footer a {
        color: #fff;
        text-decoration: none;
        opacity: .85;
        transition: opacity .2s, padding-left .2s;
    }
    .user-footer a:hover { opacity: 1; }
    .footer-links li { margin-bottom: .5rem; font-size: .92rem; }
    .footer-links a:hover { padding-left: 4px; }

    .footer-steps {
        font-size: .88rem;
        opacity: .85;
        padding-left: 1.1rem;
        line-height: 1.8;
    }

    .footer-social { display: flex; gap: .6rem; justify-content: center; }
    @media (min-width: 768px) { .footer-social { justify-content: flex-start; } }
    .footer-social a {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, .45);
        opacity: 1;
        transition: background .2s, transform .2s;
    }
    .footer-social a:hover {
        background: #e11d48;
        border-color: #e11d48;
        transform: translateY(-3px);
    }

    .btn-wa {
        display: inline-flex;
        align-items: center;
        padding: .55rem 1.1rem;
        border-radius: 50px;
        background: #25d366;
        color: #fff !important;
        font-weight: 600;
        font-size: .9rem;
        opacity: 1 !important;
        transition: transform .2s, box-shadow .2s;
    }
    .btn-wa:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, .3);
    }

    .footer-line { border-color: rgba(255, 255, 255, .35); }

    .btn-top {
        background: transparent;
        border: 1px solid rgba(255, 255, 255, .45);
        color: #fff;
        border-radius: 50px;
        padding: .3rem .9rem;
        font-size: .8rem;
        transition: background .2s;
    }
    .btn-top:hover { background: rgba(255, 255, 255, .15); }
</style>