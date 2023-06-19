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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    theme: {
        extend: {
            animation: {
                "fade-out-right": //animate-　＋　左記のclass名
                    "fade-out-right 2s cubic-bezier(0.250, 0.460, 0.450, 0.940)2s   both",
            },
            keyframes: {
                "fade-out-right": {
                    "0%": {
                        transform: "translateX(0)",
                        opacity: "1",
                    },
                    to: {
                        transform: "translateX(50px)",
                        opacity: "0",
                    },
                },
            },
        },
    },

    plugins: [forms],
};


// module.exports = {
//     theme: {
//         extend: {
//             animation: {
//                 "fade-out-right": //animate-　＋　左記のclass名
//                     "fade-out-right 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940)   both",
//             },
//             keyframes: {
//                 "fade-out-right": {
//                     "0%": {
//                         transform: "translateX(0)",
//                         opacity: "1",
//                     },
//                     to: {
//                         transform: "translateX(50px)",
//                         opacity: "0",
//                     },
//                 },
//             },
//         },
//     },
// };