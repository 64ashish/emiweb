const colors = require('tailwindcss/colors')
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/**/*.blade.php",
        "./resources/**/*.js",
        // "./resources/**/*.vue",
    ],
    theme: {
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            sky:colors.sky,
            blue:colors.blue,
            black: colors.black,
            green: colors.green,
            white: colors.white,
            gray: colors.gray,
            emerald: colors.emerald,
            indigo: colors.indigo,
            yellow: colors.yellow,
            red: colors.red,
        },
        extend: {
            content: {
                'sort': 'url("/images/sort-table.svg")',
            },
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
        // ...
    ],
}
