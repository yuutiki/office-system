import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './node_modules/flowbite/**/*.js'
    ],

    darkMode: 'class',

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
                "slide-in-top": 
                    "slide-in-top 0.5s cubic-bezier(0.215, 0.610, 0.355, 1.000)   both",
                "slide-out-top": 
                    "slide-out-top 1s cubic-bezier(0.600, -0.080, 0.735, 0.045) 3s  both",


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
                "slide-in-top": {
                    "0%": {
                        transform: "translateY(-1000px)",
                        opacity: "0"
                    },
                    to: {
                        transform: "translateY(0)",
                        opacity: "1"
                    },
                },
                "slide-out-top": {
                    "0%": {
                        transform: "translateY(0)",
                        opacity: "1"
                    },
                    to: {
                        transform: "translateY(-1000px)",
                        opacity: "0"
                    }
                }
    
            },
        },
    },
    plugins: [forms,require('flowbite/plugin')],
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



//tailwind.config.js 
//FreeBSD-licensed CSS animation by Animista 
// module.exports = {
//     theme: {
//         extend: {
//             animation: {
//                 "slide-out-top": "slide-out-top 1s cubic-bezier(0.600, -0.280, 0.735, 0.045) 1.5s  both"
//             },
//             keyframes: {
//                 "slide-out-top": {
//                     "0%": {
//                         transform: "translateY(0)",
//                         opacity: "1"
//                     },
//                     to: {
//                         transform: "translateY(-1000px)",
//                         opacity: "0"
//                     }
//                 }
//             }
//         }
//     }
// }