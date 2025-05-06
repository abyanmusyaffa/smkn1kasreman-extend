import defaultTheme from "tailwindcss/defaultTheme";
import preset from "./vendor/filament/support/tailwind.config.preset";
const { addDynamicIconSelectors } = require("@iconify/tailwind");

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                poppins: ["Poppins", "sans-serif"],
            },
            fontSize: {
                "2xs": ["10px", "14px"],
            },
            boxShadow: {
                skanka: "4px 4px 10px rgba(235, 235, 235, 0.90)",
            },
            keyframes: {
                "infinite-scroll": {
                    "0%": { transform: "translateX(0)" },
                    "100%": { transform: "translateX(-100%)" },
                },
            },
            animation: {
                "partners-scroll": "infinite-scroll 15s linear infinite",
            },
        },
    },
    plugins: [
        addDynamicIconSelectors(),
        require('@tailwindcss/typography'),
    ],
};
