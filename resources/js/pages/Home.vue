<template>
    <header class="header">

        <!--<div class="overlay"></div>-->
    </header>

    <section class="tops">
        <img class="tops-image" src="../images/larg.jpg" alt="">
        <h3 class="htitle">Фриланс-услуги в один клик:
            <br>просто,быстро,эффективно</h3>
        <div class="searchbar__home">
            <div class="container">
                <form class="search_form" action="">
                    <input type="text" placeholder="    Создать сайт" name="search" autocomplete="off" v-model="title" />
                    <button class="btn btn-outline-secondary" type="submit">Найти</button>
                </form>
            </div>
        </div>
    </section>

    <section>
        <div class="rubrics">
            <h1>Выберите рубрику, чтобы начать</h1>
            <div class=" rubrics__items">
                <div class=" rubrics_item">
                    <a class="rubrics__link"><router-link :to="{ name: 'Design' }">
                            <img src="../images/des.png" alt=""></router-link>
                    </a>
                </div>
                <div class=" rubrics_item">
                    <a class="rubrics__link"><router-link :to="{ name: 'Development' }">
                            <img src="../images/it.png" alt=""></router-link>
                    </a>
                </div>
                <div class=" rubrics_item">
                    <a class="rubrics__link"><router-link :to="{ name: 'Texts' }">
                            <img src="../images/tex.png" alt=""></router-link>
                    </a>
                </div>
                <div class=" rubrics_item">
                    <a class="rubrics__link"><router-link :to="{ name: 'Seo' }">
                            <img src="../images/seo.png" alt=""></router-link>
                    </a>
                </div>
            </div>
            <div class=" rubrics__items">
                <div class=" rubrics_item">
                    <a class="rubrics__link"><router-link :to="{ name: 'Social' }">
                            <img src="../images/sic.png" alt=""></router-link>
                    </a>
                </div>

            </div>
        </div>


        <div class="start__panel">
            <div class="start__bg"></div>
            <div class="start_inner">
                <div class="start_txt">
                    <h2 class="start__banner"> Закажите услуги фрилансеров прямо сейчас</h2>
                    <div class="start__text">Быстро, просто и безопасно!</div>
                    <button class="start__btn"><router-link :to="{ name: 'CreatePosts' }" class="start__btn"> Начать
                        </router-link></button>
                </div>

            </div>

        </div>
        <div class="container">
            <div class="row bottom__items">

                <h2 class="ck-wrapper">Chik — это потрясающе удобная фриланс платформа, которая включает:</h2>
                <div class="col-md-6">
                    <h4 class="chik-header--h4 p-o">Магазин фриланс услуг</h4>
                    <p>Желаете сэкономить финансы, время и избежать лишних стрессов? Эта экономия возможна лишь тогда,
                        когда фриланс ориентирован на конечный результат. В этом аспекте Chik, как площадка, обладает
                        значительным преимуществом перед другими ресурсами для поиска исполнителей.</p>
                    <p>Специалисты фиксируют свои услуги в виде "чиков", которые доступны к приобретению всего в один
                        клик... Таким образом, работа исполнителей представлена как товар, что сокращает затраты
                        времени, финансов и энергии. Это идеальное решение для стандартных задач: создание сайтов,
                        различные IT услуги, Трафик, реклама, SEO и других.</p>
                    <p>Важно отметить, что каталог и поиск услуг настроены таким образом, что вы видите наилучшие
                        предложения на основе отзывов, качества работы и ответственности фрилансера. Если специалист
                        предоставляет некачественные услуги, его Чики падают вниз по списку, и мы не отображаем их перед
                        заказчиками. Таким образом, на Chik вы взаимодействуете с высококвалифицированными
                        профессионалами, стремящимися выполнить задачи на высшем уровне.</p>
                </div>
                <div class="col-md-6">
                    <h4 class="chik-header--h4 p-o">Биржа фриланса</h4>
                    <p>"Создаёте задачу, и она становится доступной для тысяч фрилансеров, готовых отправить вам свои
                        предложения. Вам лишь остаётся выбрать наилучшее из них и начать сотрудничество. Такой подход к
                        удалённой работе является идеальным вариантом для решения крупных и уникальных заданий.</p>
                    <p>Одной из характерных особенностей биржи Chik является качество предложений от фрилансеров. Если
                        вы когда-либо работали на других площадках фриланса, то знаете, как неудобно получать множество
                        несвязанных с вашим заданием предложений от исполнителей, которые даже не удосужились прочитать
                        его текст. На Chik же всё иначе – благодаря особому функционалу каждый фрилансер ценит каждое
                        своё предложение. Поэтому подавляющее большинство полученных предложений приходит от тех, кто
                        внимательно изучил суть задачи и предлагает соответствующие решения.</p>
                    <p>Ещё одним важным моментом на бирже фриланса и в магазине Kwork является безопасная оплата
                        заказов, проходящая через специальную систему: исполнитель получает деньги только после вашего
                        одобрения результатов. В случае задержки вы всегда можете вернуть денежные средства на свой счёт
                        всего в один клик."</p>
                </div>

            </div>
        </div>
    </section>
    <!--<section class="cards-blog latest-blog">
    <div class="card-blog-content" v-for="post in posts" :key="post.id">
      <img :src="post.imagePath" alt="" />
      <p>
        {{ post.created_at }}
        <span style="float: right">Written By {{ post.user }}</span>
      </p>
      <h4 style="font-weight: bolder">
        <a href="single-blog.html"></a>
        <router-link
          :to="{
            name: 'SingleBlog',
            params: { slug: post.slug },
          }"
          >{{ post.title }}</router-link
        >
      </h4>
    </div>
  </section>-->


    <router-view></router-view>



</template>
<script>
export default {
    emits: ["updateSidebar"],
    data() {
        return {
            posts: [],
        };
    },

    mounted() {
        axios
            .get("/api/home-posts")
            .then((response) => (this.posts = response.data.data))
            .catch((error) => {
                console.log(error);
            });

    },

};
</script>
<style>
.btn {
    margin-top: -1.5px;
    background-color: #8c093d;
}

@media screen and (max-width: 768px) {
    .tops {
        backdrop-filter: blur(0px) brightness(1.2);
        -webkit-backdrop-filter: blur(8px) brightness(1.2);
    }

    .btn {
        margin-top: -1px;
    }
}

@media screen and (max-width: 768px) {
    .tops {
        /*background-image: url("images/diverse.jpg");*/
        height: 200px;
        width: 100vw;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .tops-image {
        height: 200px;
        visibility: hidden;
    }

}

.tops-image {
    /* height: 100vh; */
    /* width: 100vw; */
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.tops {
    /*background-image: url("images/diverse.jpg");*/
    /* height: 100%; */
    /* width: 100vw; */
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.talentcategory {
    display: grid;
}

.freelanceh3 {
    display: flex;
    justify-content: center;

}

.rubrics {
    margin-left: 50px;
    margin-right: 50px;
    margin-top: 64px;
    display: table;
    /*width: 100%;*/
    height: 494px;
}

.rubrics h1 {

    color: #111;
    font-size: 27px;
    font-weight: 600;
    line-height: 32px;
    margin-top: -2px;
    padding: 0 0 2px;
}

.rubrics__items {

    -webkit-box-align: center;
    -ms-flex-align: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    align-items: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    justify-content: center;
    margin: 13px -6px 0;
}

.rubrics_item {

    box-sizing: border-box;
    padding: 6px;
    width: 50%;


}

.start__bg {
    width: 100%;
    transform: translateY(-10.596px);
}

.start_inner {
    width: 100%;
    height: 412px;
    background-image: url(../images/faq4.jpg);
    padding-bottom: 30px;
    padding-top: 32px;
    position: relative;
}

.start__banner {

    color: #111;
    font-size: 27px;
    font-weight: 600;
    line-height: 32px;
    margin-top: -2px;
    padding: 0 0 2px;
}

.start__text {
    color: #333;
    justify-content: center;
    font-weight: 600;

    margin-top: 16px;
    font-size: 18px;
    line-height: 24px;
}

.htitle {
    position: absolute;
    color: black;
    display: block;
    left: 70px;
    justify-content: left;
    justify-items: left;
    font-weight: 600;
    /*align-items: enter;*/
    padding-bottom: 200px;
    font-size: 25px;
    /* padding-top: 64px;*/
}

.start_txt {
    display: grid;
    justify-content: center;
    justify-items: center;
    align-items: center;
    padding-bottom: 30px;
    padding-top: 64px;
    height: 312px;
    position: relative;
}

.start__btn {
    margin-top: 64px;
    width: 333px;

    font-family: Open Sans, Helvetica, sans-serif;
    font-size: 14px;
    font-weight: 600;
    line-height: 20px;

    min-height: 48px;
    padding: 12px 15px;
    background-color: #8c093d;
    border-color: #8c093d;
    color: #fff;
    border-radius: 6px;
    border: 1px solid transparent;

}

.start__panel {
    margin-top: 120px;
    margin-bottom: 50px;
}

.bottom__items {
    top: 50px;
    margin-bottom: 10px;
}

@media (min-width: 768px) {
    .rubrics_item {
        width: 25%;
    }
}

@media (max-width: 768px) {
    .tops {
        /*background-image: url("images/diverse.jpg");*/
        height: 200px;
        width: 100vw;
    }

    .rubrics_item {
        width: 50%;
    }

    .start__panel {
        margin-top: 120px;
        margin-bottom: 10px;
    }

    .rubrics {
        margin-left: 50px;
        margin-right: 50px;
        margin-top: 64px;
        display: block;
        /*width: 100%;*/
        height: 660px;
    }

    .start_inner {
        width: 100%;
        height: 412px;
        background-image: url(../images/faq4.jpg);
        padding-bottom: 30px;
        padding-top: 32px;
        position: relative;
    }

    .start__banner {

        color: #111;
        font-size: 23px;
        font-weight: 600;
        line-height: 32px;
        margin-top: -2px;
        padding: 0 0 2px;
    }

    .start__text {
        color: #333;
        justify-content: center;
        font-weight: 600;

        margin-top: 16px;
        font-size: 18px;
        line-height: 24px;
    }

    .start_txt {
        display: grid;
        justify-content: center;
        justify-items: center;
        align-items: center;
        padding-bottom: 30px;
        padding-top: 64px;
        height: 312px;
        position: relative;
    }

    .start__btn {
        margin-top: 64px;
        width: 333px;

        font-family: Open Sans, Helvetica, sans-serif;
        font-size: 14px;
        font-weight: 600;
        line-height: 20px;

        min-height: 48px;
        padding: 12px 15px;
        background-color: #8c093d;
        border-color: #8c093d;
        color: #fff;
        border-radius: 6px;
        border: 1px solid transparent;

    }

    .htitle {
        position: absolute;
        color: black;
        display: block;
        left: 120px;
        justify-content: left;
        justify-items: left;
        font-weight: 600;
        /*align-items: enter;*/
        padding-bottom: 150px;
        font-size: 18px;
        /* padding-top: 64px;*/
    }
}

@media (max-width: 480px) {
    .htitle {
        position: absolute;
        color: black;
        display: block;
        left: 60px;
        justify-content: left;
        justify-items: left;
        font-weight: 600;
        /*align-items: enter;*/
        padding-bottom: 150px;
        font-size: 12px;
        /* padding-top: 64px;*/
    }

    .start__banner {

        color: #111;
        font-size: 18px;
        font-weight: 600;
        line-height: 32px;
        margin-top: -2px;
        padding: 0 0 2px;
    }

    .rubrics {
        margin-left: 50px;
        margin-right: 50px;
        margin-top: 64px;
        display: block;
        /*width: 100%;*/
        height: 460px;
    }

    .rubrics h1 {
        font-size: 18px;
    }

    .start__panel {
        margin-top: 20px;
        margin-bottom: 10px;
    }
}

@media (max-width: 375px) {
    .tops {
        /*background-image: url("images/diverse.jpg");*/
        height: 200px;
        width: 100vw;
    }

    .rubrics_item {
        width: 50%;
    }

    .start__panel {
        margin-top: 50px;
        margin-bottom: 10px;
    }

    .rubrics {
        margin-left: 50px;
        margin-right: 50px;
        margin-top: 64px;
        display: block;
        /*width: 100%;*/
        height: 400px;
    }

    .rubrics h1 {
        font-size: 16px;
    }

    .start_inner {
        width: 100%;
        height: 412px;
        background-image: url(../images/faq4.jpg);
        padding-bottom: 30px;
        padding-top: 32px;
        position: relative;
    }

    .start__banner {

        color: #111;
        font-size: 14px;
        font-weight: 600;
        line-height: 32px;
        margin-top: -2px;
        padding: 0 0 2px;
    }

    .start__text {
        color: #333;
        justify-content: center;
        font-weight: 600;

        margin-top: 16px;
        font-size: 14px;
        line-height: 24px;
    }

    .start_txt {
        display: grid;
        justify-content: center;
        justify-items: center;
        align-items: center;
        padding-bottom: 30px;
        padding-top: 64px;
        height: 312px;
        position: relative;
    }

    .start__btn {
        margin-top: 64px;
        width: 333px;

        font-family: Open Sans, Helvetica, sans-serif;
        font-size: 14px;
        font-weight: 600;
        line-height: 20px;

        min-height: 48px;
        padding: 12px 15px;
        background-color: #8c093d;
        border-color: #8c093d;
        color: #fff;
        border-radius: 6px;
        border: 1px solid transparent;

    }

    .start__panel {
        margin-top: 10px;
        margin-bottom: 50px;
    }

    .htitle {
        position: absolute;
        color: black;
        display: block;
        left: 50px;
        justify-content: left;
        justify-items: left;
        font-weight: 600;
        /*align-items: enter;*/
        padding-bottom: 150px;
        font-size: 9px;
        /* padding-top: 64px;*/
    }
}
</style>
