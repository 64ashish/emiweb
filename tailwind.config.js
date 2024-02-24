const colors = require('tailwindcss/colors');

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/**/*.blade.php",
        "./resources/**/*.js",
        // "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                sky: colors.sky,
                blue: colors.blue,
                black: colors.black,
                green: colors.green,
                white: colors.white,
                gray: colors.gray,
                emerald: colors.emerald,
                indigo: colors.indigo,
                yellow: colors.yellow,
                red: colors.red,
            },
            
            gridTemplateColumns: {
                'sm': 'repeat(1, minmax(0, 1fr))' // Anpassa efter dina behov
            },
        },
    },
    variants: {
        extend: {
            scale: ["hover", "active", "group-hover"],
        },
    },
    
    plugins: [
        require('@tailwindcss/forms'),
    ],
    entry: './src/index.js',
};
