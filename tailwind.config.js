/** @type {import('tailwindcss').Config} */
const content = require('fast-glob').sync([
  "./view/admin/settings-page.php",
  "./view/**/*.php"
]);
console.log(content)
module.exports = {
  content,
  theme: {
    extend: {},
  },
  plugins: [],
  corePlugins: {
    preflight: false,
  }
}

