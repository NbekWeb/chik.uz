<template>
  <div id="wrapper">
    <!-- sidebar -->
    <nav class="navbar navbar-light navbar-expand-md">
      <div class="container-fluid">
        <!--<a class="navbar-brand logo" href="#"><router-link :to="{ name: 'Home' }"
              ><img src="./images/l2.png" ></router-link
            ></a>-->
        <a class="navbar-brand logo2" href="#"
          ><router-link :to="{ name: 'Home' }"><img src="./images/l2.png" /></router-link
        ></a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar">
          <span class="visually-hidden">Toggle navigation</span>
          <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbar" class="collapse navbar-collapse">
          <div class="row ms-auto">
            <div class="col-12 ps-0">
              <ul
                class="navbar-nav float-none float-md-end d-flex justify-content-md-around"
              >
                <li class="nav-item dropdown">
                  <!--<a class="nav-link active" href="#">Home</a>-->
                  <a
                    class="nav-link dropdown-toggle"
                    @click="$router.push('/design')"
                    role="button"
                    aria-expanded="false"
                  >
                    Дизайн
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Intejerextejer' }"
                          >Интерьер и экстерьер</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Outdooradvertising' }"
                          >Наружная реклама</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Printing' }"
                          >Полиграфия</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Editing' }"
                          >Обработка и редактирование</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Mobiledesign' }"
                          >Веб и мобильный дизайн</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Industrialdesign' }"
                          >Промышленный дизайн</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Art' }"
                          >Арт и иллюстрации</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Logo' }"
                          >Логотип и брендинг</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Presentations' }"
                          >Презентации и инфографика</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Marketplace' }"
                          >Маркетплейсы и соцсети</router-link
                        ></a
                      >
                    </li>
                  </ul>
                </li>
                <li class="nav-item dropdown">
                  <a
                    class="nav-link dropdown-toggle"
                    @click="$router.push('/development')"
                    role="button"
                    aria-expanded="false"
                  >
                    Разработка и IT
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Layout' }">Верстка</router-link></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Scripts' }"
                          >Скрипты и боты</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Usability' }"
                          >Юзабилити, тесты и помощь</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Sitesetup' }"
                          >Доработка и настройка сайта</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Desktop' }"
                          >Десктоп программирование</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Application' }"
                          >Мобильные приложения</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Sitemaking' }"
                          >Создание сайтов</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Games' }">Игры</router-link></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Server' }"
                          >Сервера и хостинг</router-link
                        ></a
                      >
                    </li>
                  </ul>
                </li>
                <li class="nav-item dropdown">
                  <a
                    class="nav-link dropdown-toggle"
                    @click="$router.push('/texts')"
                    role="button"
                    aria-expanded="false"
                  >
                    Тексты и Переводы
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Makingtexts' }"
                          >Набор текста</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Cv' }"
                          >Резюме и вакансии</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Sitecontent' }"
                          >Тексты и наполнение сайта</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Businesstexts' }"
                          >Продающие и бизнес тексты</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Translates' }"
                          >Переводы</router-link
                        ></a
                      >
                    </li>
                  </ul>
                </li>
                <li class="nav-item dropdown">
                  <a
                    class="nav-link dropdown-toggle"
                    @click="$router.push('/seo')"
                    role="button"
                    aria-expanded="false"
                  >
                    SEO и трафик
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Statics' }"
                          >Статистика и аналитика</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Trafics' }">Трафик</router-link></a
                      >
                    </li>
                    <li>
                      <a class="cat"
                        ><router-link :to="{ name: 'Websitepromotion' }"
                          >Продвижение сайта в топ</router-link
                        ></a
                      >
                    </li>
                  </ul>
                </li>
                <li class="nav-item dropdown">
                  <a
                    class="nav-link dropdown-toggle"
                    @click="$router.push('/social')"
                    role="button"
                    aria-expanded="false"
                  >
                    Соцсети и реклама
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="cat" href="#"
                        ><router-link :to="{ name: 'Reklame' }"
                          >Контекстная реклама</router-link
                        ></a
                      >
                    </li>
                    <hr />
                    <li>
                      <a class="cat" href="#"
                        ><router-link :to="{ name: 'Marketplace' }"
                          >Маркетплейсы</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat" href="#"
                        ><router-link :to="{ name: 'Databasez' }"
                          >Базы данных</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat" href="#"
                        ><router-link :to="{ name: 'Pr' }">Реклама и PR</router-link></a
                      >
                    </li>
                    <li>
                      <a class="cat" href="#"
                        ><router-link :to="{ name: 'Emailinks' }"
                          >Email рассылки</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat" href="#"
                        ><router-link :to="{ name: 'Smm' }">SMM</router-link></a
                      >
                    </li>
                    <li>
                      <a class="cat" href="#"
                        ><router-link :to="{ name: 'Study' }"
                          >Обучение и консалтинг</router-link
                        ></a
                      >
                    </li>
                    <li>
                      <a class="cat" href="#"
                        ><router-link :to="{ name: 'Siteselling' }"
                          >Продажа сайтов</router-link
                        ></a
                      >
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
            <div class="col-12 ps-0 order-md-first">
              <ul class="navbar-nav d-flex justify-content-end">
                <li class="nav-item ms-md move-left">
                  <div class="input-group">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Что ищем, напишите"
                      aria-describedby="basic-addon2"
                    />
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button">
                        Найти
                      </button>
                    </div>
                  </div>
                </li>
                <li class="nav-item ms-md move-right" v-if="!loggedIn">
                  <a class="nav-link signin">
                    <i class="fa-solid"></i>
                    <router-link :to="{ name: 'Login' }">Вход</router-link>
                  </a>
                  <a class="nav-link sign" href="#">
                    <i class="fa-sharp fa-solid fa-arrow-right-to-bracket"></i>
                    <router-link class="sign" :to="{ name: 'Register' }"
                      >Регистрация</router-link
                    >
                  </a>
                </li>
                <li class="nav-item ms-md move-right" v-if="loggedIn">
                  <a class="nav-link signin">
                    <i class="fa-solid"></i>
                    <router-link :to="{ name: 'DashboardPostsList' }"
                      >Проекты</router-link
                    >
                  </a>
                </li>
                <li class="nav-item ms-md move-right" v-if="loggedIn">
                  <a class="nav-link signin prof">
                    <i class="fa-solid"></i>
                    <router-link :to="{ name: 'Dashboard' }"
                      ><div class="btn-group">
                        <button
                          class="btn btn-secondary btn-sm dropdown-toggle"
                          type="button"
                          data-bs-toggle="dropdown"
                          data-bs-auto-close="true"
                          aria-expanded="false"
                        >
                          Профил
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item" href="#"
                              ><router-link :to="{ name: 'Dashboard' }">
                                Профил
                              </router-link></a
                            >
                          </li>
                          <li><a class="dropdown-item" @click="logout">Log out</a></li>
                        </ul>
                      </div></router-link
                    >
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <main class="container-fluid p-0">
      <!-- render components depending on the page visited -->

      <router-view
        @update-sidebar="updateSidebar"
        @show-edit-success="showEditSuccess"
        :editSuccess="editSuccess"
        :key="$route.path"
      ></router-view>
    </main>

    <hr />
    <!-- Main footer -->
    <div class="footer">
      <div class="heading">
        <h2>Chik<sup>™</sup></h2>
      </div>
      <div class="content">
        <div class="details">
          <!--<p>
            Lorem ipsum dolor sit amet consectetur <br />
            adipisicing elit. Cupiditate, qui!
          </p>-->
          <h4 class="mail">Email</h4>
          <p><a href="#">infochik@gmail.com</a></p>
        </div>
        <div class="services">
          <p>
            <a href=""><router-link :to="{ name: 'Design' }">Дизайн</router-link></a>
          </p>
          <p>
            <a
              ><router-link :to="{ name: 'Development' }">Разработка и IT</router-link></a
            >
          </p>
          <p>
            <a><router-link :to="{ name: 'Texts' }">Тексты и Переводы</router-link></a>
          </p>
          <p>
            <a><router-link :to="{ name: 'Seo' }">SEO и трафик</router-link></a>
          </p>
        </div>
        <div class="services">
          <p>
            <a><router-link :to="{ name: 'Social' }">Соцсети и реклама</router-link></a>
          </p>
          <p>
            <a><router-link :to="{ name: 'Games' }">Фрилансеру</router-link></a>
          </p>
          <p>
            <a><router-link :to="{ name: 'Printing' }">Покупателям</router-link></a>
          </p>
          <p>
            <a
              ><router-link :to="{ name: 'Statics' }"
                >Статистика и аналитика</router-link
              ></a
            >
          </p>
        </div>
        <div class="footerlinks">
          <p>
            <a
              ><router-link :to="{ name: 'Home' }"
                >Политика конфиденциальности PRIVACY</router-link
              ></a
            >
          </p>
          <p>
            <a href="#"
              ><router-link :to="{ name: 'Dashboard' }">About Chik</router-link></a
            >
          </p>
          <p>
            <a href="#"
              ><router-link :to="{ name: 'Dashboard' }"
                >Пользовательское соглашение</router-link
              ></a
            >
          </p>
          <p>
            <a href="#"
              ><router-link :to="{ name: 'Contact' }">Способы оплаты</router-link></a
            >
          </p>
        </div>
      </div>
    </div>
    <footer>
      <hr />
      © 2024 Chik Freelance Uzbekistan
    </footer>
  </div>
</template>
<script>
export default {
  data() {
    return {
      overlayVisibility: false,
      loggedIn: false,
      editSuccess: false,
    };
  },
  methods: {
    logout() {
      axios
        .post("/api/logout")
        .then((response) => {
          this.$router.push({ name: "Home" });
          localStorage.removeItem("authenticated");
          this.$emit("updateSidebar");
        })
        .catch((error) => console.log(error));
    },
    ShowOverlay() {
      this.overlayVisibility = true;
    },

    hideOverlay() {
      this.overlayVisibility = false;
    },

    updateSidebar() {
      this.loggedIn = !this.loggedIn;
    },

    showEditSuccess() {
      this.editSuccess = true;
    },
  },

  mounted() {
    if (localStorage.getItem("authenticated")) {
      this.loggedIn = true;
    } else {
      this.loggedIn = false;
    }
  },
};
</script>
<style scoped>
.dropdown-menu li {
  text-underline-offset: ;
  text-shadow: none;
  padding-left: 20px;
  width: 250px;
}
.dropdown-menu li a {
  padding-top: 10px;
  padding-bottom: 10px;
}
.btn {
  border-radius: 0 4px 4px 0;
  background-color: #04b70a;
  color: #fff;
  border-color: #04b70a;
}
.sign {
  border-color: #04b70a;
  border-radius: 4px;
  background-color: #04b70a;
  color: #fff !important;
  /*margin-left: 20px;*/
  margin-right: 40px;
  justify-content: center;
  align-items: center;
}
.signin {
  margin-right: 0px;
  color: #111;
  font-size: 14px;
  font-weight: 400;
  line-height: 20px;
  padding: 10px 8px;
}
.navbar-nav {
  width: calc(100vw - 24px);
}

.navbar-brand {
  position: absolute;
  top: calc(0px + 8px);
  padding: 8px;
}
.move-left {
  margin-right: 500px;
}
.move-right a {
  margin-right: 0px;

  display: inline-block;
}
.move-right {
  margin-right: 40px;
}

.logo2 {
  width: 100px;
  position: absolute;
  top: calc(0px + 0px);
  padding: 8px;
  /*visibility: hidden;*/
}
.btn-group {
  height: 25px;
  top: -5px;
}
@media screen and (max-width: 767px) {
  .move-left {
    margin-right: 125px;
  }
  .sign {
    width: 200px;
  }
  .logo {
    /*visibility: hidden;*/
  }
  .logo2 {
    /*visibility: hidden;*/
  }
  .navbar-brand {
    position: relative;
    top: 0;
  }

  .move-right a {
    display: block;
  }
  .prof {
    visibility: hidden;
  }
}
@media screen and (max-width: 480px) {
  .logo2 {
    width: 70px;
    height: 50px;
    visibility: visible;
  }
  .logo {
    width: 70px;
    height: 50px;
    visibility: visible;
  }
  .navbar-brand {
    position: relative;
    top: 0;
  }

  .move-right a {
    display: block;
  }
  .prof {
    visibility: hidden;
  }
}
@media screen and (max-width: 360px) {
  .logo2 {
    width: 70px;
    height: 50px;
    visibility: visible;
  }
  .logo {
    width: 70px;
    height: 50px;
    visibility: visible;
  }
  .navbar-brand {
    position: relative;
    top: 0;
  }
  .prof {
    visibility: hidden;
  }
  .move-right a {
    display: block;
  }
}
.navbar {
  color: #333;
}
.showOverlay {
  width: 100%;
  z-index: 5;
}
.dropbtn {
  background-color: #f6f6f6;
  color: #333;
  padding: 12px;
  font-size: 17px;
  border: none;
}
.dropdown:hover .dropdown-menu {
  display: block;
}
.dropdown {
  position: relative;
  display: inline-block;
}
.navdropdown {
  padding: 0 50px;
}
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  /*box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);*/
  z-index: 1;
}

.dropdown-content a {
  color: #333;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {
  background-color: #ddd;
  color: #2c98e0;
}

.dropdown:hover .dropdown-content {
  display: block;
}

.dropdown:hover .dropbtn {
  background-color: #2c98e0;
  color: rgba(253, 252, 253, 0.712);
}
.headerTop {
  z-index: 100;
}
nav {
  z-index: 100;
  position: sticky;
  top: 0;
  left: 0;
  width: 100%;
  /*padding: 16px 20px 30px 20px;*/
  display: flex;
  align-items: center;
  transition: 0.3s ease-out;
  backdrop-filter: blur(0px) brightness(1.2);
  -webkit-backdrop-filter: blur(8px) brightness(1.2);
  /*text-shadow: 0 0 5px rgba(0,0,0,0.5);*/
  color: #333;
  font-size: 16px;

  border-top: 1px solid #e2e2e2;
}

a {
  color: #333;
  text-decoration: none;
  font-weight: 400;
}
.menu--right {
  /*height: 40px;*/
  display: flex;
  margin-top: 0;
}
.menuToggle {
  flex-basis: 60%;
  display: flex;
}
.menuItem {
  align-items: center;
  justify-content: center;

  display: flex;
  list-style: none;
  /*margin: 6px 8px 20px 56px;*/

  font-weight: 300;
  /*margin-bottom: 50px;*/
}
.logoleft {
  flex-basis: 20%;
}
.menuItem li {
  align-items: center;
  justify-content: center;
  display: flex;
  list-style: none;
  margin: 6px 8px 0px 56px;

  font-weight: 300;
  /*margin-bottom: 50px;*/
}

.list {
  list-style-type: none;
  margin-left: auto;
  display: flex;
  height: 100px;
  align-items: center;
}
/*.footer_img{
  width: 100px;
}*/
.logo {
  display: flex;
  width: 90px;
  height: 45px;
  margin-right: 200px;
  margin-left: 40px;
}
/*.column{
  display: flex;
  background-color: rgb(39, 39, 39);
  color: white;
  padding: 20px 80px 20px 80px;
}
.colomunsecond{
  display: flex;
  color: white;
  background-color: black;
  padding: 10px 30px 10px 200px;
  height: 60px;
  width: 100%;
}
.footer{
  background-color: rgb(39, 39, 39);
}*/

#primary_nav_wrap {
  flex-basis: 20%;
}
#primary_nav_wrap ul {
  left: 0px;
  top: 0px;
  list-style: none;
  position: relative;

  color: rgb(0, 0, 0);
  margin: 0;
  padding: 0;
  display: inline-table;
}

#primary_nav_wrap ul a {
  display: block;
  color: #000000;
  text-decoration: none;
  font-weight: 710;
  font-size: 14px;
  line-height: 32px;
  padding: 15px 15px;

  font-family: "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
  -webkit-transition: all 150ms linear;
  -moz-transition: all 150ms linear;
  -ms-transition: all 150ms linear;
  -o-transition: all 150ms linear;
  transition: all 150ms linear;
}

#primary_nav_wrap ul a:hover {
  color: #000000;
  background-color: white;
  /*text-shadow: 0 0 2px #2d2f33;
-webkit-text-shadow: 0 0 2px #2d2f33;
-moz-text-shadow: 0 0 2px #2d2f33;
-o-text-shadow: 0 0 2px #2d2f33;
-ms-text-shadow: 0 0 2px #2d2f33;*/
  -webkit-transition: all 150ms linear;
  -moz-transition: all 150ms linear;
  -ms-transition: all 150ms linear;
  -o-transition: all 150ms linear;
  transition: all 150ms linear;
}

#primary_nav_wrap ul a:active {
  color: #8abf29;
  background-color: white;
  -webkit-transition: all 50ms linear;
  -moz-transition: all 50ms linear;
  -ms-transition: all 50ms linear;
  -o-transition: all 50ms linear;
  transition: all 50ms linear;
}

#primary_nav_wrap ul li {
  position: relative;
  float: left;
  margin: 0;
  padding: 0;
}

#primary_nav_wrap ul li.current-menu-item {
  background-color: white;
}

#primary_nav_wrap ul li:hover {
  background-color: white;
}

#primary_nav_wrap ul ul {
  display: none;
  position: absolute;
  top: 100%;
  left: 0;

  padding: 0;
}

#primary_nav_wrap ul ul li {
  float: none;
  width: 200px;
}

#primary_nav_wrap ul ul a {
  line-height: 120%;
  padding: 10px 15px;
  background-color: white;
}

#primary_nav_wrap ul ul ul {
  top: 0;
  left: 100%;
}

#primary_nav_wrap ul li:hover > ul {
  display: block;
}

.cat {
  backdrop-filter: blur(0px) brightness(1.2);
}
.cat {
  color: #9c9c9c;
  -webkit-transition: all 100ms linear;
  -moz-transition: all 100ms linear;
  -ms-transition: all 100ms linear;
  -o-transition: all 100ms linear;
  transition: all 100ms linear;
}

.cat:hover {
  color: white;
  -webkit-transition: all 100ms linear;
  -moz-transition: all 100ms linear;
  -ms-transition: all 100ms linear;
  -o-transition: all 100ms linear;
  transition: all 100ms linear;
}
.menuToggle input {
  visibility: hidden;
}
.cate {
  color: #000000;
  font-size: 12px;
}
@media (max-width: 768px) {
  .sidebar {
    right: 0;
    top: 0;
    position: absolute;
    width: 300px;
    padding: 50px;
    padding-top: 125px;
    background: #ededed;
    list-style-type: none;
    -webkit-font-smoothing: antialiased;
    transform-origin: 0% 0%;
    transition: transform 0.5s cubic-bezier(0.77, 0.2, 0.05, 1);
    li {
      padding: 10px 0;
      font-size: 22px;
    }
  }

  .logoleft {
    position: relative;
    left: 100px;
  }
  .menuToggle {
    display: block;
    position: relative;
    top: 50px;
    z-index: 1;
    -webkit-user-select: none;
    user-select: none;
    a {
      text-decoration: none;
      color: #232323;
      transition: all 0.3s ease;
      &:hover {
        color: tomato;
      }
    }
    input {
      visibility: visible;
      display: block;
      width: 40px;
      height: 32px;
      position: absolute;
      top: -7px;
      cursor: pointer;
      opacity: 0; /* hide this */
      z-index: 2; /* and place it over the hamburger */
      -webkit-touch-callout: none;
    }
    span {
      position: relative;
      display: block;
      width: 33px;
      height: 4px;
      margin-bottom: 5px;
      position: relative;
      background: #cdcdcd;
      border-radius: 3px;
      z-index: 1;
      transform-origin: 4px 0px;
      transition: transform 0.5s cubic-bezier(0.77, 0.2, 0.05, 1),
        background 0.5s cubic-bezier(0.77, 0.2, 0.05, 1), opacity 0.55s ease;
      &:first-child {
        transform-origin: 0% 0%;
      }
      &:nth-last-child(2) {
        transform-origin: 0% 100%;
      }
    }
  }

  .menuToggle {
    input {
      &:checked ~ span {
        opacity: 1;
        transform: rotate(45deg) translate(-2px, -1px);
        background: #232323;
        &:nth-last-child(3) {
          opacity: 0;
          transform: rotate(0deg) scale(0.2, 0.2);
        }
        &:nth-last-child(2) {
          transform: rotate(-45deg) translate(0, -1px);
        }
      }
      &:checked ~ .menuItem {
        transform: none;
      }
    }
  }

  .menuItem {
    display: block;
    position: absolute;
    width: 300px;
    padding: 50px;
    padding-top: 125px;
    background: #ededed;
    list-style-type: none;
    -webkit-font-smoothing: antialiased;
    transform-origin: 0% 0%;
    transition: transform 0.5s cubic-bezier(0.77, 0.2, 0.05, 1);
    li {
      padding: 10px 0;
      font-size: 22px;
    }
  }

  .menu--right {
    .menuToggle {
      position: fixed;
      right: 0;
      input {
        right: 50px;
      }
      span {
        right: 50px;
      }
    }
    .menuItem {
      right: 0;
      margin: -100px 0 0 0;
      transform: translate(100%, 0);
      li {
        a {
          &:hover {
            padding-left: 5px;
          }
        }
      }
    }
  }
  #primary_nav_wrap {
    flex-basis: 30%;
    right: 267px;
    position: absolute;
  }
  #primary_nav_wrap {
    flex-basis: 20%;
  }
  #primary_nav_wrap ul {
    left: 0px;
    top: 0px;
    list-style: none;
    position: relative;

    color: rgb(0, 0, 0);
    margin: 0;
    padding: 0;
    display: inline-table;
  }

  #primary_nav_wrap ul a {
    display: block;
    color: #2d2f33;
    text-decoration: none;
    font-weight: 710;
    font-size: 14px;
    line-height: 32px;
    padding: 15px 15px;

    font-family: "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
    -webkit-transition: all 150ms linear;
    -moz-transition: all 150ms linear;
    -ms-transition: all 150ms linear;
    -o-transition: all 150ms linear;
    transition: all 150ms linear;
  }

  #primary_nav_wrap ul a:hover {
    color: #2d2f33;
    background-color: white;
    /*text-shadow: 0 0 2px #2d2f33;
-webkit-text-shadow: 0 0 2px #2d2f33;
-moz-text-shadow: 0 0 2px #2d2f33;
-o-text-shadow: 0 0 2px #2d2f33;
-ms-text-shadow: 0 0 2px #2d2f33;*/
    -webkit-transition: all 150ms linear;
    -moz-transition: all 150ms linear;
    -ms-transition: all 150ms linear;
    -o-transition: all 150ms linear;
    transition: all 150ms linear;
  }

  #primary_nav_wrap ul a:active {
    color: #8abf29;
    background-color: white;
    -webkit-transition: all 50ms linear;
    -moz-transition: all 50ms linear;
    -ms-transition: all 50ms linear;
    -o-transition: all 50ms linear;
    transition: all 50ms linear;
  }

  #primary_nav_wrap ul li {
    position: relative;
    float: left;
    margin: 0;
    padding: 0;
  }

  #primary_nav_wrap ul li.current-menu-item {
    background-color: white;
  }

  #primary_nav_wrap ul li:hover {
    background-color: white;
  }

  #primary_nav_wrap ul ul {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;

    padding: 0;
  }

  #primary_nav_wrap ul ul li {
    float: none;
    width: 200px;
  }

  #primary_nav_wrap ul ul a {
    line-height: 120%;
    padding: 10px 15px;
    background-color: white;
  }

  #primary_nav_wrap ul ul ul {
    top: 0;
    left: 100%;
  }

  #primary_nav_wrap ul li:hover > ul {
    display: block;
  }
  .colu {
    width: 250px;
    margin: 0 60px 10px 0;
    flex-basis: 60%;
  }
}
@media (max-width: 360px) {
  .sidebar {
    right: 0;
    top: 0;
    position: absolute;
    width: 200px;
    padding: 30px;
    padding-top: 90px;
    background: #ededed;
    list-style-type: none;
    -webkit-font-smoothing: antialiased;
    transform-origin: 0% 0%;
    transition: transform 0.5s cubic-bezier(0.77, 0.2, 0.05, 1);
    li {
      padding: 10px 0;
      font-size: 18px;
    }
  }
  .logoleft {
    position: relative;
    left: 100px;
    height: 50px;
  }

  .menuToggle {
    display: block;
    position: relative;
    top: 30px;
    z-index: 1;
    -webkit-user-select: none;
    user-select: none;
    a {
      text-decoration: none;
      color: #232323;
      transition: all 0.3s ease;
      &:hover {
        color: tomato;
      }
    }
    input {
      visibility: visible;
      display: block;
      width: 30px;
      height: 25px;
      position: absolute;
      top: -4px;
      cursor: pointer;
      opacity: 0; /* hide this */
      z-index: 2; /* and place it over the hamburger */
      -webkit-touch-callout: none;
    }
    span {
      position: relative;
      display: block;
      width: 25px;
      height: 4px;
      margin-bottom: 5px;
      position: relative;
      background: #cdcdcd;
      border-radius: 3px;
      z-index: 1;
      transform-origin: 4px 0px;
      transition: transform 0.5s cubic-bezier(0.77, 0.2, 0.05, 1),
        background 0.5s cubic-bezier(0.77, 0.2, 0.05, 1), opacity 0.55s ease;
      &:first-child {
        transform-origin: 0% 0%;
      }
      &:nth-last-child(2) {
        transform-origin: 0% 100%;
      }
    }
  }

  .menuToggle {
    input {
      &:checked ~ span {
        opacity: 1;
        transform: rotate(45deg) translate(-2px, -1px);
        background: #232323;
        &:nth-last-child(3) {
          opacity: 0;
          transform: rotate(0deg) scale(0.2, 0.2);
        }
        &:nth-last-child(2) {
          transform: rotate(-45deg) translate(0, -1px);
        }
      }
      &:checked ~ .menuItem {
        transform: none;
      }
    }
  }

  .menuItem {
    display: block;
    position: absolute;
    width: 200px;
    padding: 30px;
    padding-top: 90px;
    background: #ededed;
    list-style-type: none;
    -webkit-font-smoothing: antialiased;
    transform-origin: 0% 0%;
    transition: transform 0.5s cubic-bezier(0.77, 0.2, 0.05, 1);
    li {
      padding: 10px 0;
      font-size: 18px;
    }
  }

  .menu--right {
    .menuToggle {
      position: fixed;
      right: 0;
      input {
        right: 30px;
      }
      span {
        right: 30px;
      }
    }
    .menuItem {
      right: 0;
      margin: -80px 0 0 0;
      transform: translate(100%, 0);
      li {
        a {
          &:hover {
            padding-left: 5px;
          }
        }
      }
    }
  }
  #primary_nav_wrap {
    flex-basis: 30%;
    right: 121px;
    position: absolute;
  }
  #primary_nav_wrap {
    flex-basis: 20%;
  }
  #primary_nav_wrap ul {
    left: 0px;
    top: 0px;
    list-style: none;
    position: relative;

    color: rgb(0, 0, 0);
    margin: 0;
    padding: 0;
    display: inline-table;
  }

  #primary_nav_wrap ul a {
    display: block;
    color: #2d2f33;
    text-decoration: none;
    font-weight: 710;
    font-size: 14px;
    line-height: 32px;
    padding: 15px 15px;

    font-family: "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
    -webkit-transition: all 150ms linear;
    -moz-transition: all 150ms linear;
    -ms-transition: all 150ms linear;
    -o-transition: all 150ms linear;
    transition: all 150ms linear;
  }

  #primary_nav_wrap ul a:hover {
    color: #2d2f33;
    background-color: white;
    /*text-shadow: 0 0 2px #2d2f33;
-webkit-text-shadow: 0 0 2px #2d2f33;
-moz-text-shadow: 0 0 2px #2d2f33;
-o-text-shadow: 0 0 2px #2d2f33;
-ms-text-shadow: 0 0 2px #2d2f33;*/
    -webkit-transition: all 150ms linear;
    -moz-transition: all 150ms linear;
    -ms-transition: all 150ms linear;
    -o-transition: all 150ms linear;
    transition: all 150ms linear;
  }

  #primary_nav_wrap ul a:active {
    color: #8abf29;
    background-color: white;
    -webkit-transition: all 50ms linear;
    -moz-transition: all 50ms linear;
    -ms-transition: all 50ms linear;
    -o-transition: all 50ms linear;
    transition: all 50ms linear;
  }

  #primary_nav_wrap ul li {
    position: relative;
    float: left;
    margin: 0;
    padding: 0;
  }

  #primary_nav_wrap ul li.current-menu-item {
    background-color: white;
  }

  #primary_nav_wrap ul li:hover {
    background-color: white;
  }

  #primary_nav_wrap ul ul {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;

    padding: 0;
  }

  #primary_nav_wrap ul ul li {
    float: none;
    width: 200px;
  }

  #primary_nav_wrap ul ul a {
    line-height: 120%;
    padding: 10px 15px;
    background-color: white;
  }

  #primary_nav_wrap ul ul ul {
    top: 0;
    left: 100%;
  }

  #primary_nav_wrap ul li:hover > ul {
    display: block;
  }
  .colu {
    width: 250px;
    margin: 0 60px 10px 0;
    flex-basis: 60%;
  }
  /*.footer_text{
        font-size: 12px;
        width: 720px;
}
footer small {
    display: inline-block;
    margin-top: 15px;
}
.colu2{
    color: #fdfdfd;
    padding: 50px 20px 0 10px;
    margin: 0 30px 0 10px;
    width: 500px;
    flex-basis: 20%;
}
.colubotom{
    font-size: 12px;
    display: flex;

    align-items: center;
    flex-basis: 80%;
}
.colubtnd{
    flex-basis: 20%;
}
.colubtn{
    background-color: rgb(233, 116, 141);
    margin-left: 80px;
    display: flex;
    justify-content: center;
    border: none;
}
.colu3{
    color: #fdfdfd;
    padding: 50px 20px 0 10px;
    width: 500px;
    flex-basis: 20%;
}*/

  .nav {
    height: 50px;
    width: 100%;
    background-color: #4d4d4d;
    position: relative;
  }

  .nav > .nav-header {
    display: inline;
  }

  .nav > .nav-header > .nav-title {
    display: inline-block;
    font-size: 22px;
    color: #fff;
    padding: 10px 10px 10px 10px;
  }

  .nav > .nav-btn {
    display: none;
  }

  .nav > .nav-links {
    display: inline;
    float: right;
    font-size: 18px;
  }

  .nav > .nav-links > a {
    display: inline-block;
    padding: 13px 10px 13px 10px;
    text-decoration: none;
    color: #efefef;
  }

  .nav > .nav-links > a:hover {
    background-color: rgba(0, 0, 0, 0.3);
  }

  .nav > #nav-check {
    display: none;
  }

  @media (max-width: 600px) {
    .nav > .nav-btn {
      display: inline-block;
      position: absolute;
      right: 0px;
      top: 0px;
    }
    .nav > .nav-btn > label {
      display: inline-block;
      width: 50px;
      height: 50px;
      padding: 13px;
    }
    .nav > .nav-btn > label:hover,
    .nav #nav-check:checked ~ .nav-btn > label {
      background-color: rgba(0, 0, 0, 0.3);
    }
    .nav > .nav-btn > label > span {
      display: block;
      width: 25px;
      height: 10px;
      border-top: 2px solid #eee;
    }
    .nav > .nav-links {
      position: absolute;
      display: block;
      width: 100%;
      background-color: #333;
      height: 0px;
      transition: all 0.3s ease-in;
      overflow-y: hidden;
      top: 50px;
      left: 0px;
    }
    .nav > .nav-links > a {
      display: block;
      width: 100%;
    }
    .nav > #nav-check:not(:checked) ~ .nav-links {
      height: 0px;
    }
    .nav > #nav-check:checked ~ .nav-links {
      height: calc(100vh - 50px);
      overflow-y: auto;
    }
  }
}
</style>
