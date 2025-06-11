import './bootstrap';

// ===== IMPORT LIBRARY JAVASCRIPT =====

// 1. Import Alpine.js dan plugin Intersect (untuk animasi saat scroll)
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

// 2. Import library untuk QR Code Scanner
import { Html5Qrcode } from "html5-qrcode";
import Swal from 'sweetalert2';

// ===== IMPORT CSS =====
import '@fortawesome/fontawesome-free/css/all.min.css';

// ===== CUSTOM JAVASCRIPT (JIKA ADA) =====
// import './mobile-menu.js'; // <-- Ini tidak lagi diperlukan karena fungsinya sudah di-handle Alpine.js. Sebaiknya dihapus.

// ===== INISIALISASI =====

// 1. Jadikan library bisa diakses secara global (agar bisa dipanggil dari Blade)
window.Alpine = Alpine;
window.Html5Qrcode = Html5Qrcode; // <-- Baris ini sekarang akan berfungsi dengan benar
window.Swal = Swal; // <-- Baris ini sekarang akan berfungsi dengan benar

// 2. Daftarkan plugin Alpine.js
Alpine.plugin(intersect);

// 3. Mulai Alpine.js
Alpine.start();