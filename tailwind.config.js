module.exports = {
    mode: 'jit',
    purge: [
        './templates/**/*.html.twig',
        './assets/**/*.css',
        './assets/**/*.scss',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            fontFamily: {
                'sans': ['Raleway', 'sans-serif'],
            }
        },
    },
    variants: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/jit'),
        require("@tailwindcss/forms"),
    ],
};
