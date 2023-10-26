import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'
// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  server: {
    host: '0.0.0.0',
  },
  resolve: {
    alias: {
      // 设置 '@' 指向 'src' 目录
      '@': path.resolve(__dirname, 'src'),
    },
  },
})
