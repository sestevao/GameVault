import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            perspective: {
                '1000': '1000px',
            },
            rotate: {
                'y-180': '180deg',
            },
            colors: {
                'purper-dark': '#201233',
                'purple-mid': '#381f59',
                'purple-light': '#502c7f',
                'green-dark': '#009c97',
                'green-mid': '#00CFC8',
                'green-light': '#03fff6',
            }
        },
    },
    variants: {
        extend: {
            perspective: ['group-hover'],
            transform: ['group-hover'],
            rotate: ['group-hover'],
        },
    },
    plugins: [],
};
