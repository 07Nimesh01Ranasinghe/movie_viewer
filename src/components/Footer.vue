
<template>
  <footer class="footer-section">
    <div class="footer-content">
      <div class="footer-left">
        <h3><strong>IT Group</strong></h3>
        <p>C. Salvador de Madariaga, 1</p>
        <p>28027 Madrid</p>
        <p>Spain</p>
      </div>
      <div class="footer-right">
        <div class="social-container">
          <p>Follow us on</p>
          <div class="social-icons">
            <a href="https://x.com/ebeyonds" class="icon-wrapper">
              <img src="/src/assets/twitter.png" alt="Twitter" />
            </a>
            <a href="https://www.youtube.com/c/Ebeyonds" class="icon-wrapper">
              <img src="/src/assets/youtube.png" alt="YouTube" />
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>Copyright © 2022 IT Hotels. All rights reserved.</p>
      <p>Photos by Felix Mooneeram & <a href="#">Serge Kutuzov</a> on <a href="#">Unsplash</a></p>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'FooterSection'
};
</script>

<style scoped>
.footer-section {
  background-color: #1D1D1D;
  color: white;
  padding: 30px 70px;
}

.footer-content {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  padding-bottom: 20px;
  border-bottom: 1px solid #444;
}

.footer-left p {
  margin: 5px 0;
}

.footer-right {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.social-container {
  display: flex;
  align-items: center;
  gap: 15px;
}

.social-icons {
  display: flex;
  align-items: center;
  gap: 10px;
}

.icon-wrapper img {
  width: 20px;
  height: 20px;
}

.footer-bottom {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
  font-size: 0.9rem;
}

.footer-bottom a {
  color: white;
  text-decoration: underline;
}

  /* Tablets */
   @media (min-width: 769px) and (max-width: 1024px) {
  .footer-section {
    padding: 20px 30px;
  }

  .footer-bottom {
    flex-direction: column;
    gap: 10px;
    text-align: center;
  }
}


 /* Mobile */
   @media (max-width: 768px) {
  .footer-section {
    padding: 20px 20px;
  }

  .footer-content {
    flex-direction: column;
    align-items: center;
    gap: 20px;
  }

  .footer-left{
    text-align: center;
  }

  .footer-right {
    align-items: center;
    text-align: center;
  }

  .footer-bottom {
    flex-direction: column;
    align-items: center;
    gap: 5px;
    text-align: center;
  }
}


</style>
