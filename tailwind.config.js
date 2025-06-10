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
                ubuntu: ['Ubuntu', 'sans-serif'],
            },
        },
        colors:
        {
            primary:'#e9580c',
            textColor:'#5c5c5c',
        },
    },
    plugins: [],
};
