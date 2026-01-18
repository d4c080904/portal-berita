/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./resources/**/*.ts",
    "./app/Http/Controllers/**/*.php",
    "./app/View/Components/**/*.php",
    "./app/Livewire/**/*.php",
    "./storage/framework/views/*.php",
  ],
  theme: {
    extend: {
      colors: {
        'primary': '#e53e3e', // warna merah Tempo
        'primary-dark': '#c53030',
        'gray-soft': '#f7fafc',
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      },
      container: {
        center: true,
        padding: '1rem',
      },
    },
  },
  plugins: [],
}

module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.ts",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontSize: {
        'headline': '2rem',
        'subhead': '1.5rem',
        'body': '1rem',
      },
      lineHeight: {
        'tight': '1.2',
        'normal': '1.5',
        'relaxed': '1.7',
      },
      maxWidth: {
        '7xl': '1280px',
      },
    },
  },
  plugins: [],
}