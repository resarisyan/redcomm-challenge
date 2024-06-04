<template>
  <Swiper
    :modules="[SwiperAutoplay, SwiperEffectCreative, SwiperNavigation]"
    :slides-per-view="1"
    :loop="true"
    :autoplay="{
      delay: 2000,
      disableOnInteraction: true,
    }"
    :navigation="true"
    :effect="'creative'"
    :creative-effect="{
      prev: {
        shadow: false,
        translate: ['-20%', 0, -1],
      },
      next: {
        translate: ['100%', 0, 0],
      },
    }"
  >
    <SwiperSlide
      v-for="(slide, index) in slides"
      :key="index"
      class="swiper-slide"
    >
      <img :src="slide.url" alt="slide" class="w-full h-full object-cover" />
    </SwiperSlide>
  </Swiper>
</template>

<script lang="ts" setup>
const slides = ref([
  {
    url: '/assets/images/book1.jpeg',
  },
  {
    url: '/assets/images/book2.jpeg',
  },
  {
    url: '/assets/images/book3.jpeg',
  },
  {
    url: '/assets/images/book4.jpeg',
  },
  {
    url: '/assets/images/book5.jpeg',
  },
]);
</script>

<style>
.swiper-slide {
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 18px;
  height: 50vh;
  font-size: 4rem;
  font-weight: bold;
  font-family: 'Roboto', sans-serif;
}

.swiper-button-next,
.swiper-button-prev {
  background-color: rgba(0, 0, 0, 0.5);
  color: white;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
  transition: background-color 0.3s, transform 0.3s;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
  background-color: rgba(0, 0, 0, 0.8);
  transform: scale(1.1);
}

.swiper-button-next:after,
.swiper-button-prev:after {
  font-size: 16px;
}
</style>
