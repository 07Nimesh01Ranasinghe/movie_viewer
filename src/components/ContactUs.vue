<template>
  <div class="contact-section">
    <div class="contact-content">
      <div class="contact-header">
        <h1>How to reach us</h1>
        <p>Lorem ipsum dolor sit amet, consetetur.</p>
      </div>
      <div class="contact-body">
        <div class="form-container">
          <form @submit.prevent="submitForm">
            <div class="form-group">
              <label for="first-name">First Name *</label>
              <input type="text" id="first-name" v-model="firstName" required />
            </div>
            <div class="form-group">
              <label for="last-name">Last Name *</label>
              <input type="text" id="last-name" v-model="lastName" required />
            </div>
            <div class="form-group full-width">
              <label for="email">Email *</label>
              <input type="email" id="email" v-model="email" required />
            </div>
            <div class="form-group full-width">
              <label for="telephone">Telephone</label>
              <input type="text" id="telephone" v-model="telephone" />
            </div>
            <div class="form-group full-width">
              <label for="message">Message</label>
              <textarea id="message" v-model="message"></textarea>
            </div>
            <p class="required-fields">*required fields</p>
            <div class="checkbox">
              <input type="checkbox" id="terms" v-model="agree" required />
              <label for="terms">I agree to the <a href="#">Terms & Conditions</a></label>
            </div>
            <div class="submit-container">
              <button type="submit" class="submit-btn">SUBMIT</button>
            </div>
          </form>
        </div>
        <div class="map-container">
          <iframe
            :src="mapLink"
            width="100%"
            height="100%"
            allowfullscreen=""
            loading="lazy"
          ></iframe>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ContactUs',
  data() {
    return {
      firstName: '',
      lastName: '',
      email: '',
      telephone: '',
      message: '',
      agree: false,
      mapLink: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.3812075643614!2d79.9404323!3d6.844821199999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25069caa2f53b%3A0xe7eae3a8b1f1214d!2seBEYONDS%20eBusiness%20%26%20Digital%20Solutions!5e0!3m2!1sen!2slk!4v1735616718500!5m2!1sen!2slk'
    };
  },
  methods: {
    async submitForm() {
      if (this.agree) {
        const formData = {
          firstName: this.firstName,
          lastName: this.lastName,
          email: this.email,
          telephone: this.telephone,
          message: this.message
        };

        try {
          const response = await fetch('http://localhost/movie_viewer/submit.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
          });


          const text = await response.text();
          let data;

          try {
            data = JSON.parse(text);
          } catch (error) {
            console.error('Invalid JSON response:', text);
            throw new Error('Invalid JSON format from server.');
          }

          if (response.ok && data.success) {
            alert('Form submitted successfully!');
          } else {
            const errorMessage = data?.message || 'Form submission failed.';
            alert(errorMessage);
          }

        } catch (error) {
          console.error('Error submitting form:', error);
          alert('An error occurred while submitting the form. Please try again.');
        }
      } else {
        alert('You must agree to the Terms & Conditions.');
      }
    }
  }


};
</script>

<style scoped>
.contact-section {
  background-color: black;
  color: white;
  padding: 20px 70px;
}

.contact-content {
  width: 100%;
}

.contact-header {
  margin-bottom: 60px;
  line-height: 1rem;
}

.contact-header h1{
  font-size: 36.57px
}

.contact-header p{
  font-size: 16px;
}

.contact-body {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  gap: 10px;
  padding-bottom: 20px;

}

.form-container {
  width: 40%;
}

.map-container {
  width: 50%;
  height: 500px;
  display: flex;
  justify-content: flex-end;
}

form {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  width: 48%;
}

.full-width {
  width: 100%;
}

input, textarea {
  padding: 10px;
  border: none;
  border-radius: 5px;
  background-color: #333;
  color: white;
}

.submit-container {
  display: flex;
  justify-content: flex-end;
  width: 100%;
}

.submit-btn {
  padding: 10px 30px;
  background-color: #CC9601;
  color: white;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}

.checkbox {
  display: flex;
  align-items: center;
  gap: 10px;
}

.checkbox a {
  color: white;
  text-decoration: underline;
}

.required-fields {
  margin-bottom: 10px;
}


  /* Tablet */
   @media (min-width: 769px) and (max-width: 1024px) {
  .contact-body {
    flex-direction: column;
    align-items: flex-start;
  }

  .form-container {
    width: 100% !important;
    margin-bottom: 20px;
  }

  .map-container {
    width: 100% !important;
    height: 400px;
  }

  .contact-header h1 {
    font-size: 28px;
  }
  .contact-header p {
    font-size: 14px;
  }

  form {
    flex-direction: column;
  }
  .form-group {
    width: 100% !important;
  }
}


  /* Mobile */
   @media (max-width: 768px) {
  .contact-section {
    padding: 20px 20px;
  }
  .contact-header h1 {
    font-size: 24px;
  }
  .contact-header p {
    font-size: 14px;
  }

  .contact-body {
    flex-direction: column;
    align-items: center;
  }
  .form-container {
    width: 100% !important;
  }
  .map-container {
    width: 100% !important;
    height: 300px;
    margin-top: 20px;
  }

  form {
    flex-direction: column;
    gap: 15px;
  }
  .form-group {
    width: 100% !important;
  }
}

</style>
