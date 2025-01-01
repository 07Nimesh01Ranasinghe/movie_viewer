<template>
  <div class="movie-collection">
    <div class="header">
      <h1>Collect your favourites</h1>
      <div class="input-container">
        <img src="/src/assets/search.png" alt="Search" class="icon" />
        <input
          v-model="searchQuery"
          @input="fetchMovies"
          placeholder="Search title and add to grid"
          type="text"
        />
        <div v-if="searchResults.length" class="dropdown">
          <div
            v-for="movie in searchResults.slice(0, 10)"
            :key="movie.id"
            class="dropdown-item"
          >
            <img :src="movie.image" alt="Movie Poster" class="dropdown-img" />
            <span>{{ movie.title }}</span>
            <button @click="addToFavoritesAndShow(movie)" class="add-btn">Add</button>
          </div>
        </div>
      </div>

    </div>

    <hr class="divider"/>

    <div class="favorite-slider">
      <div :class="['favorite-grid', { 'single': favoriteMovies.length === 1 }]">
        <div
          v-for="movie in paginatedMovies"
          :key="movie.id"
          class="movie-card"
        >
          <img :src="movie.image" alt="Movie Poster" />
          <div class="movie-info">
            <h2>{{ movie.title }}</h2>
            <p :ref="`description-${movie.id}`">{{ movie.description }}</p>
          </div>
          <button @click="removeMovie(movie.id)" class="remove-btn">&times;</button>
        </div>
      </div>
    </div>


    <div class="dot-container" v-if="totalPages > 1">
      <span
        v-for="(dot, index) in totalPages"
        :key="index"
        :class="{ 'active-dot': currentPage === index }"
        @click="currentPage = index"
      >•</span>
    </div>
  </div>
</template>


<script>
import axios from 'axios';

export default {
  name: 'MovieGrid',
  data() {
    return {
      searchQuery: '',
      movies: [],
      searchResults: [],
      favoriteMovies: [],
      isTruncated: false,
      currentPage: 0,
      itemsPerPage: 3,
      isTablet: false
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.favoriteMovies.length / this.itemsPerPage);
    },
    paginatedMovies() {
      const start = this.currentPage * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.favoriteMovies.slice(start, end);
    }
  },
  mounted() {
    this.fetchFavoriteMovies();


    this.handleResize();

    window.addEventListener('resize', this.handleResize);
  },
  beforeUnmount() {

    window.removeEventListener('resize', this.handleResize);
  },
  methods: {

    handleResize() {
      const width = window.innerWidth;

      if (width <= 1024 && width >= 769) {
        this.isTablet = true;
        this.itemsPerPage = 4;
      } else {
        this.isTablet = false;
        this.itemsPerPage = 3;
      }

      this.currentPage = 0;
    },

    async fetchMovies() {
      if (this.searchQuery.length < 3) {
        this.searchResults = [];
        return;
      }
      try {
        const response = await axios.get(
          'https://api.themoviedb.org/3/search/movie',
          {
            params: {
              include_adult: 'false',
              language: 'en-US',
              page: '1',
              query: this.searchQuery
            },
            headers: {
              accept: 'application/json',
              Authorization:
                'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIxZmY0NDg2YmQ4NTE4ZTkxYWUzMGIzYjJjNTIyMDY5ZiIsIm5iZiI6MTczNTYxMzk3NS4wMTksInN1YiI6IjY3NzM1ZTE2NjNmOTBmOGY2NjkyOGMyMiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.mDmZc_h5LGHIQRC5Uv21orQSMwQ1dpEru3y_ZAHW8js'
            }
          }
        );
        this.searchResults = response.data.results.map((item) => ({
          id: item.id,
          title: item.title,
          image: item.poster_path
            ? `https://image.tmdb.org/t/p/w500${item.poster_path}`
            : 'placeholder.jpg'
        }));
      } catch (error) {
        console.error('Error fetching movies:', error);
      }
    },

    async fetchFavoriteMovies() {
      try {
        const response = await axios.get(
          'https://api.themoviedb.org/3/account/21719881/favorite/movies',
          {
            headers: {
              accept: 'application/json',
              Authorization:
                'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIxZmY0NDg2YmQ4NTE4ZTkxYWUzMGIzYjJjNTIyMDY5ZiIsIm5iZiI6MTczNTYxMzk3NS4wMTksInN1YiI6IjY3NzM1ZTE2NjNmOTBmOGY2NjkyOGMyMiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.mDmZc_h5LGHIQRC5Uv21orQSMwQ1dpEru3y_ZAHW8js'
            }
          }
        );
        this.favoriteMovies = response.data.results.map((item) => ({
          id: item.id,
          title: item.title,
          image: item.poster_path
            ? `https://image.tmdb.org/t/p/w500${item.poster_path}`
            : 'placeholder.jpg',
          description: item.overview || 'No description available.'
        }));
      } catch (error) {
        console.error('Error fetching favorite movies:', error);
      }
    },

    async addToFavorites(movieId) {
      try {
        await axios.post(
          'https://api.themoviedb.org/3/account/21719881/favorite',
          {
            media_type: 'movie',
            media_id: movieId,
            favorite: true
          },
          {
            headers: {
              accept: 'application/json',
              'content-type': 'application/json',
              Authorization:
                'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIxZmY0NDg2YmQ4NTE4ZTkxYWUzMGIzYjJjNTIyMDY5ZiIsIm5iZiI6MTczNTYxMzk3NS4wMTksInN1YiI6IjY3NzM1ZTE2NjNmOTBmOGY2NjkyOGMyMiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.mDmZc_h5LGHIQRC5Uv21orQSMwQ1dpEru3y_ZAHW8js'
            }
          }
        );
        alert('Movie added to favorites!');
        this.fetchFavoriteMovies();
      } catch (error) {
        console.error('Error adding to favorites:', error);
      }
    },

    addToFavoritesAndShow(movie) {
      this.favoriteMovies.unshift(movie);
      this.addToFavorites(movie.id);
    },

    slideRight() {
      this.favoriteMovies.push(this.favoriteMovies.shift());
    },

    async removeMovie(id) {

      this.favoriteMovies = this.favoriteMovies.filter((movie) => movie.id !== id);


      try {
        await axios.post(
          'https://api.themoviedb.org/3/account/21719881/favorite',
          {
            media_type: 'movie',
            media_id: id,
            favorite: false
          },
          {
            headers: {
              accept: 'application/json',
              'content-type': 'application/json',
              Authorization:
                'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIxZmY0NDg2YmQ4NTE4ZTkxYWUzMGIzYjJjNTIyMDY5ZiIsIm5iZiI6MTczNTYxMzk3NS4wMTksInN1YiI6IjY3NzM1ZTE2NjNmOTBmOGY2NjkyOGMyMiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.mDmZc_h5LGHIQRC5Uv21orQSMwQ1dpEru3y_ZAHW8js'
            }
          }
        );
      } catch (error) {
        console.error('Error removing from favorites:', error);

        this.fetchFavoriteMovies();
      }
    },

    checkTruncation() {
      this.favoriteMovies.forEach((movie) => {
        const description = this.$refs[`description-${movie.id}`][0];
        if (description.scrollHeight > description.clientHeight) {
          movie.isTruncated = true;
        } else {
          movie.isTruncated = false;
        }
      });
    },

    expandDescription(id) {

      alert(`Show full description for movie ID: ${id}`);
    }
  }
};
</script>

<style scoped>
.movie-collection {
  color: white;
  background-color: #1D1D1D;
  padding: 10px 70px;
  text-align: center;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.header h1{
  font-size: 2vw;
}

.input-container{
  position: relative;
  display: inline-block;
  width: 300px;
}

.input-container .icon {
  position: absolute;
  left: 15px;
  top: 50%;
  transform: translateY(-50%);
  width: 20px;
  height: 20px;
  pointer-events: none;
}

.input-container input {
  width: 100%;
  padding: 12px 12px 12px 45px;
  border: 0.5px solid white;
  border-radius: 5px;
  font-size: 1vw;
  background-color: #1D1D1D;
  color: white;
  outline: none;
  box-sizing: border-box;
}



.favorite-slider {
  display: flex;
  justify-content: center;
  align-items: center;
}

.favorite-grid {
  display: flex;
  gap: 40px;
  justify-content: center;
}

.favorite-grid.single {
  justify-content: flex-start;
}


.movie-card {
  height: 770px;
  width: 427px;
  border-radius: 5px;
  overflow: hidden;
  position: relative;
}

.movie-card img{
  height: 606px;
  width: 427px;
}

.movie-info {
  background: #3C3C3C;
  text-align: left;
  padding: 15px;
  min-height: 120px;
}

h2 {
  margin: 0 0 10px;
  font-size: 24px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 100%;
}

p {
  margin: 0;
  font-size: 14px;
  line-height: 1.5;
  max-height: 4.5em;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
}

.read-more {
  color: white;
  cursor: pointer;
  font-size: 16px;
  display: inline;
  margin-top: 5px;
}

.remove-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  background: #1D1D1D;
  color: white;
  border: 2.29px #B7B7B7;
  font-size: 1.5rem;
  cursor: pointer;
}

.dropdown {
  position: absolute;
  background: #333;
  width: 300px;
  border-radius: 5px;
  margin-top: 5px;
  z-index: 1000;
  max-height: 400px;
  overflow-y: auto;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.dropdown-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px;
  border-bottom: 1px solid #555;
}

.dropdown-img {
  width: 40px;
  height: 60px;
  object-fit: cover;
  margin-right: 10px;
}

.add-btn {
  background: #CC9601;
  color: black;
  border: none;
  padding: 5px 10px;
  cursor: pointer;
  border-radius: 3px;
}
.scroll-indicator {
  padding: 10px;
  text-align: center;
  color: #bbb;
  font-size: 14px;
}

.dot-container {
  display: flex;
  justify-content: center;
  margin-top: 10px;
}

.dot-container span {
  font-size: 24px;
  cursor: pointer;
  margin: 0 5px;
  color: white;
}

.dot-container .active-dot {
  color: #CC9601;
}



@media screen and (max-width: 1024px) and (min-width: 769px) {
  .favorite-grid {
    flex-wrap: wrap;
    justify-content: space-around;
  }

  .header {
    flex-direction: column;
    align-items: flex-start;
  }

  .movie-card {
    width: 45%;
    margin: 20px 0;

  }

  .movie-card img {
    width: 100%;
  }

}

@media (max-width: 768px) {
  .movie-collection {
    padding: 10px 20px;
  }

  .header {
    flex-direction: column;
    align-items: center;
  }
  .header h1 {
    font-size: 1.5rem;
    margin-bottom: 15px;
  }
  .input-container {
    width: 100% !important;
  }
  .input-container input {
    font-size: 1rem;
  }

  .favorite-grid {
    flex-direction: column;
    gap: 20px;
    align-items: center;
  }

  .movie-card {
    width: 90%;
    max-width: 400px;
    height: auto;
    margin: 0 auto;
  }
  .movie-card img {
    width: 100%;
    height: auto;
  }
}

</style>
