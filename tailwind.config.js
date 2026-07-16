import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                display: ['Urbanist', ...defaultTheme.fontFamily.sans],
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    navy: '#0f172a',
                    blue: '#1e3a5f',
                    mint: '#059669',
                    light: '#f8fafc',
                },
            },
            letterSpacing: {
                tighter: '-0.04em',
                widest: '0.25em',
            },
            backdropBlur: {
                xs: '2px',
            },
        },
    },
    plugins: [forms],
};
