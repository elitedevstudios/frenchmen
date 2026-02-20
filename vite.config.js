import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
	build: {
		outDir: 'assets',
		emptyOutDir: false,
		manifest: true,
		rollupOptions: {
			input: {
				main: resolve(__dirname, 'src/js/main.js'),
				style: resolve(__dirname, 'src/css/main.css'),
			},
			output: {
				entryFileNames: 'js/[name].js',
				chunkFileNames: 'js/[name].js',
				assetFileNames: (assetInfo) => {
					if (assetInfo.name && assetInfo.name.endsWith('.css')) {
						return 'css/style.css';
					}
					return 'assets/[name][extname]';
				},
			},
		},
	},
	css: {
		postcss: './postcss.config.js',
	},
});
