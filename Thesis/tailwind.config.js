/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js"
  ],
  darkMode: 'class',
  theme: {
    extend: {
      fontFamily: {
        'arial': ['Arial', 'sans-serif'],
      },
    },
  },
  plugins: [
    require('flowbite/plugin')({
        charts: true,
    }),
  ],
}

