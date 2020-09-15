module.exports = {
    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: true,
    },
    purge: [],
    theme: {
        extend: {
            colors: {
                primary: {
                    default: 'hsl(137,67%,55%)',
                    500: 'hsl(137,67%,55%)',
                    800: 'hsl(141,69%,81%)'
                },
                secondary: {
                    default: 'hsl(33,98%,51%)'
                },
                tertiary: {
                    default: 'hsl(358,84%,62%)',
                }
            },
            fontFamily: {
                'sans': [
                    'Rubik',
                ]
            },
        },
    },
    variants: {},
    plugins: [],
}
