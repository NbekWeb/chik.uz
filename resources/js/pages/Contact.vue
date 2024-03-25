<template>
  <section id="contact-us">
    <h1>Get in Touch!</h1>

    <!-- contact info -->
    <div class="container">
      <div class="contact-info">
        <div class="specific-info">
          <i class="fas fa-home"></i>
          <div>
            <p class="title">Chikr</p>
            <p class="subtitle">Tashkent</p>
          </div>
        </div>
        <div class="specific-info">
          <i class="fas fa-phone-alt"></i>
          <div>
            <a href="">+998 XXX XXX </a>
            <br />
            <a href="">+998 XXX XXX </a>

            <p class="subtitle"></p>
          </div>
        </div>
        <div class="specific-info">
          <i class="fas fa-envelope-open-text"></i>
          <div>
            <a href="mailto:info@alphayo.co.ke">
              <p class="title">chik@gmail.com</p>
            </a>
            <p class="subtitle">Send to us</p>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="contact-form">
        <form action="" method="">
          <!-- Name -->
          <label for="name"><span>Name</span></label>
          <input type="text" id="name" name="name" value="" />

          <!-- Email -->
          <label for="email"><span>Email</span></label>
          <input type="text" id="email" name="email" value="" />

          <!-- Subject -->
          <label for="subject"><span>Subject</span></label>
          <input type="text" id="Subject" name="subject" value="" />

          <!-- Message -->
          <label for="message"><span>Message</span></label>
          <textarea id="message" name="message"></textarea>

          <!-- Button -->
          <input type="submit" value="Submit" />
        </form>
      </div>
    </div>
  </section>
</template>