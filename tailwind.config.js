module.exports = {
    content: [
        "./resources/**/*.blade.php",
    ],
    theme: {
        extend: {
            colors: {
                'laravel': {
                    DEFAULT: '#FB503B',
                    '50': '#FFF1EF',
                    '100': '#FEDFDB',
                    '200': '#FDBBB3',
                    '300': '#FD978B',
                    '400': '#FC7463',
                    '500': '#FB503B',
                    '600': '#F92005',
                    '700': '#C21904',
                    '800': '#8B1203',
                    '900': '#540B02'
                },
            }
        },
    },
    plugins: [
        require('@tailwindcss/line-clamp'),
    ],
}
