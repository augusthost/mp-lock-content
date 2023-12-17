/** @type {import('tailwindcss').Config} */
module.exports = {
  content: require('fast-glob').sync([
    "./view/**/*.php"
  ]),
  theme: {
    extend: {},
  },
  plugins: [],
  corePlugins: {
    preflight: false,
  }
}

