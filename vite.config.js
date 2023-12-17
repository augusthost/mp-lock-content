import { defineConfig } from 'vite';

const plugin_name = 'mp-lock';

export default defineConfig({
    build: {
      watch: {
        include: ['./view/**/*.php'], // Specify the directory to watch
      },
      rollupOptions: {
        input: {
          app: './assets/js/app.js',
          styles: './assets/sass/app.scss'
        },
        output: {
          entryFileNames: `${plugin_name}.js`, // Customizes the app.js output filename
          chunkFileNames: '[name].[hash].js', // Customizes the chunk output filenames
          assetFileNames: (assetInfo) => {
            if (/\.css$/.test(assetInfo.name)) {
              return `${plugin_name}.css`;
            }
            return '[name].[ext]';
          }, // Customizes asset output filenames
        },
      }
    },
    plugins: [
        require('postcss'),
        {
          name: 'sass',
          apply: 'scss',
          options: {
            sass: require('sass'),
          },
        },
    ],
});