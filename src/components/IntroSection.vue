<template>
  <section class="intro-section">


    <div class="intro-image">
      <img
        :src="images[currentIndex]"
        :alt="`Slide ${currentIndex + 1}`"
      />

    </div>


    <div class="intro-content">
      <h1>MOVIE LIBRARY</h1>
      <p>
        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
        eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam
        voluptua.
      </p>
    </div>

  </section>
</template>


<script>
export default {
  name: 'IntroSection',
  data() {
    return {
      images: [
        '/src/assets/banner.png',
        '/src/assets/movie.png',
        '/src/assets/ticket.jpg'
      ],
      currentIndex: 0,
      intervalId: null
    };
  },
  mounted() {
    this.intervalId = setInterval(() => {
      this.nextImage();
    }, 4000);
  },
  beforeUnmount() {
    clearInterval(this.intervalId);
  },
  methods: {
    nextImage() {
      this.currentIndex = (this.currentIndex + 1) % this.images.length;
    },
    prevImage() {
      this.currentIndex =
        (this.currentIndex - 1 + this.images.length) % this.images.length;
    }
  }
};
</script>


<style scoped>
.intro-section {
  width: 100%;
  height: 95vh;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  color: white;
  background-color: #111;
}

.intro-image img {
  width: 100%;
  height: 60vh;
  object-fit: cover;
}

.intro-content {
  height: 40vh;
  display: flex;
  justify-content: flex-start;
  align-items: flex-start;
  flex-direction: column;
  padding: 10px 70px;
}

h1 {
  font-size: 3vw;
  margin-bottom: 0.5rem;
  text-align: left;
}

p {
  max-width: 550px;
  font-size: 1vw;
  line-height: 1.2;
  text-align: left;
  font-weight: 100;
}


  /* Tablets */
   @media (min-width: 769px) and (max-width: 1024px) {
  .intro-section {
    height: 85vh;
  }

  .intro-image img {
    height: 55vh;
    object-fit: cover;
  }

  .intro-content {
    height: 30vh;
    padding: 10px 50px;
    justify-content: center;
    align-items: flex-start;
  }


  h1 {
    font-size: 2rem;
  }

  p {
    font-size: 1rem;
    max-width: 600px;
    line-height: 1.4;
  }
}


  /* Mobiloe */
   @media (max-width: 768px) {
  .intro-section {
    height: auto;
  }

  .intro-image img {
    height: auto;
  }

  .intro-content {
    height: auto;
    padding: 20px;
    align-items: flex-start;
  }

  h1 {
    font-size: 1.8rem;
    text-align: left;
  }

  p {
    font-size: 1rem;
    line-height: 1.5;
  }
}


</style>
