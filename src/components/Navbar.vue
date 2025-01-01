
<template>
  <nav class="navbar">
    <div class="logo">
      <img src="/src/assets/Logo.png" alt="Logo" />
      <span>Logoipsum</span>
    </div>


    <div class="nav">

      <ul class="nav-links">
        <li><a href="#" class="active">HOME</a></li>
        <li><a href="#">OUR SCREENS</a></li>
        <li><a href="#">SCHEDULE</a></li>
        <li><a href="#">MOVIE LIBRARY</a></li>
        <li><a href="#">LOCATION & CONTACT</a></li>
      </ul>

      <div class="hamburger" @click="handleHamburgerClick">
        <img class="close-img"
          v-if="isMobile && showMobileMenu"
          src="/src/assets/close.png"
          alt="Close"
        />
        <img
          v-else
          src="/src/assets/burgerMenu.png"
          alt="Menu"
        />
      </div>


      <ul class="tablet-dropdown" v-if="showTabletDropdown && isTablet">
        <li><a href="#">LOCATION & CONTACT</a></li>
        <!-- You can add more links if you want -->
      </ul>
    </div>


    <ul class="mobile-nav" v-if="showMobileMenu && isMobile">
      <li><a href="#" class="active">HOME</a></li>
      <li><a href="#">OUR SCREENS</a></li>
      <li><a href="#">SCHEDULE</a></li>
      <li><a href="#">MOVIE LIBRARY</a></li>
      <li><a href="#">LOCATION & CONTACT</a></li>
    </ul>
  </nav>
</template>



<script>
export default {
  name: 'NavBar',
  data() {
    return {
      showTabletDropdown: false,
      isTablet: false,

      showMobileMenu: false,
      isMobile: false
    };
  },
  methods: {
    toggleTabletDropdown() {
      this.showTabletDropdown = !this.showTabletDropdown;
    },


    toggleMobileMenu() {
      this.showMobileMenu = !this.showMobileMenu;
    },


    handleHamburgerClick() {
      if (this.isMobile) {

        this.toggleMobileMenu();
      } else if (this.isTablet) {

        this.toggleTabletDropdown();
      } else {

        console.log('Desktop: no hamburger action');
      }
    },

    checkWidth() {
      const w = window.innerWidth;
      this.isTablet = w >= 769 && w <= 1024;
      this.isMobile = w <= 768;
    }

  },
  mounted() {
    this.checkWidth();
    window.addEventListener('resize', this.checkWidth);
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.checkWidth);
  }
};
</script>


<style scoped>
.navbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px 70px;
  background-color: black;
  color: white;
  height: 5vh;
}

.logo {
  display: flex;
  align-items: center;
}
.logo img {
  height: 30px;
  margin-right: 10px;
}

.nav{
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 15px;
}

.nav-links {
  display: flex;
  list-style: none;
}
.nav-links li {
  margin: 0 15px;
}
.nav-links a {
  color: white;
  text-decoration: none;
  font-size: 1vw;
}
.nav-links a.active {
  text-decoration: underline;
}


.hamburger {
  position: relative;
  cursor: pointer;
}
.hamburger img {
  height: 15px;
  width: 20px;
}


.tablet-dropdown {
  position: absolute;
  top: 50px;
  right: 0;
  background-color: #333;
  padding: 10px;
  border-radius: 5px;
  list-style: none;
  z-index: 9999;
}
.tablet-dropdown ul {
  margin: 0;
  padding: 0;
}
.tablet-dropdown li {
  margin-bottom: 10px;
}
.tablet-dropdown a {
  color: white;
  text-decoration: none;
}

.mobile-nav {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.98);
  list-style: none;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  z-index: 9999;
  margin: 0;
  padding: 0;
}
.mobile-nav li {
  margin: 25px 0;
}
.mobile-nav a {
  font-size: 1.8rem;
  color: white;
  text-decoration: none;
}

 /* Tablet */
@media (min-width: 769px) and (max-width: 1024px) {
  .nav-links li:last-child {
    display: none;
  }

  .hamburger img{
    width: 30px;
    height: 10px;
  }
}



/*Mobile */
@media (max-width: 768px) {
  .nav-links {
    display: none;
  }

  .close-img{
    position: relative;
    z-index: 1000001;
  }
}


</style>
