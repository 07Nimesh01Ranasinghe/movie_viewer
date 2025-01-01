<script setup>
import ContactUs from './components/ContactUs.vue';
import IntroSection from './components/IntroSection.vue';
import MovieGrid from './components/MovieGrid.vue';
import Navbar from './components/Navbar.vue';
import Footer from './components/Footer.vue';

</script>

<template>
  <Navbar/>
  <IntroSection/>
  <MovieGrid/>
  <ContactUs/>
  <Footer/>
</template>

<style>
#app {
  display: block;
}
</style>
