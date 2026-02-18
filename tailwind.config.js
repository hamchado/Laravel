/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                'cairo': ['Cairo', 'sans-serif'],
                'tajawal': ['Tajawal', 'sans-serif'],
            },
            colors: {
                primary: {
                    DEFAULT: '#4f46e5',
                    light: '#6366f1',
                    dark: '#4338ca',
                },
                secondary: {
                    DEFAULT: '#10b981',
                    light: '#34d399',
                    dark: '#059669',
                },
                accent: {
                    DEFAULT: '#ec4899',
                    light: '#f472b6',
                    dark: '#db2777',
                },
                warning: '#f59e0b',
                danger: '#ef4444',
            },
            borderRadius: {
                'sm': '8px',
                'DEFAULT': '12px',
                'lg': '16px',
                'xl': '20px',
            },
            boxShadow: {
                'sm': '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
                'DEFAULT': '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
                'lg': '0 10px 15px -3px rgba(0, 0, 0, 0.1)',
                'xl': '0 20px 25px -5px rgba(0, 0, 0, 0.1)',
            },
            spacing: {
                '18': '4.5rem',
                '22': '5.5rem',
            },
        },
    },
    plugins: [],
}
