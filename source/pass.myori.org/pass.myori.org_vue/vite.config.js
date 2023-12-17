import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'
// import mkcert from "vite-plugin-mkcert";


// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    // mkcert()
  ],
  server: {
    host: '0.0.0.0',
    https: true,
    proxy: {
      // '/api': {
      //   target: 'https://pass.myori.org/api',
      //   changeOrigin: true,
      //   rewrite: (path) => path.replace(/^\/api/, ''),
      // },
    },
  },
  resolve: {
    alias: {
      // 设置 '@' 指向 'src' 目录
      '@': path.resolve(__dirname, 'src'),
    },
  },
})
