<template>
    <section id="contact-us">
        <h1>Будем на связи!</h1>

        <!-- contact info -->
        <div class="container">
            <div class="contact-info">
                <div class="specific-info">
                    <i class="fas fa-home"></i>
                    <div>
                        <p class="title">Chik</p>
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
                            <p class="title">info@chik.uz</p>
                        </a>
                        <p class="subtitle">Отправте нам</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form">
                <form action="" method="">
                    <!-- Name -->
                    <label for="name"><span>Имя</span></label>
                    <input type="text" id="name" name="name" value="" />

                    <!-- Email -->
                    <label for="email"><span>Email</span></label>
                    <input type="text" id="email" name="email" value="" />

                    <!-- Subject -->
                    <label for="subject"><span>Субъект</span></label>
                    <input type="text" id="Subject" name="subject" value="" />

                    <!-- Message -->
                    <label for="message"><span>Текст</span></label>
                    <textarea id="message" name="message"></textarea>

                    <!-- Button -->
                    <input type="submit" value="Отправить" />
                </form>
            </div>
        </div>
    </section>
</template>
