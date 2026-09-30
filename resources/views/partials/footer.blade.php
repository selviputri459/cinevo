<footer class="user-footer mt-auto py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                <strong>Cinevo</strong>
                <div><small>Pesan tiket bioskop jadi lebih mudah.</small></div>
            </div>

            <div class="col-md-6 text-center text-md-end">
                <a href="{{ url('/') }}" class="me-3">Beranda</a>
                <a href="#" class="me-3">Tentang</a>
                <a href="#">Kontak</a>
            </div>
        </div>

        <hr class="footer-line my-3">

        <div class="text-center">
            <small>&copy; {{ date('Y') }} Cinevo. All rights reserved.</small>
        </div>
    </div>
</footer>

<style>
    .user-footer {
        /* GANTI dua warna ini dengan pink & ungu tema kamu */
        background: linear-gradient(90deg, #77254e, #58072d);
        color: #fff;
        html, body { min-height: 100%; }
    }

    .user-footer a {
        color: #fff;
        text-decoration: none;
        opacity: .9;
    }

    .user-footer a:hover {
        opacity: 1;
        text-decoration: underline;
    }

    .footer-line {
        border-color: rgba(255, 255, 255, .35);
    }
</style>