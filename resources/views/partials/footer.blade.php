<footer class="user-footer mt-auto py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                <strong>Cinevo</strong>
                <div><small>Pesan tiket bioskop jadi lebih mudah.</small></div>
                <i class="fab fa-whatsapp me-1"></i>
                Hubungi admin:
                <a href="https://wa.me/6285601516139?text=Halo%20admin%20Cinevo%2C%20saya%20mau%20bertanya"
                target="_blank" rel="noopener">0856-0151-6139</a>
            </div>

            <div class="col-md-6 text-center text-md-end">
                <a href="{{ url('/') }}" class="me-3">Beranda</a>
                <a href="#" class="me-3">Tentang</a>
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
        /* Latar footer: gradasi dari kiri ke kanan. */
        background: linear-gradient(90deg, #77254e, #58072d);
        /* Teks footer putih. */
        color: #fff;
        html, body { min-height: 100%; }
    }

    /* Link di footer putih, tanpa garis bawah, sedikit transparan. */
    .user-footer a {
        color: #fff;
        text-decoration: none;
        opacity: .9;
    }

    /* Saat disentuh mouse: opacity penuh dan muncul garis bawah. */
    .user-footer a:hover {
        opacity: 1;
        text-decoration: underline;
    }

    /* Garis pemisah putih transparan. */
    .footer-line {
        border-color: rgba(255, 255, 255, .35);
    }
</style>