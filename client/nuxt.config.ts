// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: ['@nuxt/ui', '@pinia/nuxt', 'nuxt-swiper'],
  pinia: {
    // storesDirs: ['./stores/**'],
    disableVuex: true,
  },
  typescript: {
    typeCheck: true,
  },
  runtimeConfig: {
    public: {
      API_BASE_URL: process.env.API_BASE_URL || 'http://127.0.0.1:8000/api/v1',
    },
  },
});
