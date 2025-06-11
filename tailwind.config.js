import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import daisyui from 'daisyui'; // Import DaisyUI

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',   // Penting: Tambahkan ini untuk memindai file JS
        './resources/**/*.vue',  // Penting: Tambahkan ini jika Anda menggunakan Vue.js
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms,
        daisyui, // Tambahkan DaisyUI di sini
    ],

    // ---
    // Konfigurasi DaisyUI Opsional
    // ---
    // Anda bisa mengaktifkan tema, dark mode, atau pengaturan lain di sini.
    // Hapus komentar pada baris di bawah dan sesuaikan sesuai kebutuhan Anda.
    // daisyui: {
    //     themes: ["light", "dark", "cupcake", "emerald", "synthwave"], // Contoh beberapa tema
    //     darkTheme: "dark", // Tema default untuk dark mode
    //     base: true, // Tambahkan gaya dasar DaisyUI
    //     styled: true, // Tambahkan gaya komponen DaisyUI
    //     utils: true, // Tambahkan utility class DaisyUI
    //     prefix: "", // Anda bisa menambahkan prefix pada semua class DaisyUI, misal "di-"
    //     logs: true, // Tampilkan log DaisyUI di konsol saat build
    // },
};