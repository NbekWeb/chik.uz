<template>
  
  <div class="container">
    <div >
   
   
    
   <div class="page__header">
   <h2 class="diz">Разработка и IT</h2>
   <h5>Эти программисты помогут создать даже новый Фейсбук</h5>
 </div>
 
 
   <div class="col-md-12">
    <div class="subcategory m-hidden">
        <div class="subcategory-list">
          <p><h3>Разработка и IT</h3></p>
          <a class="cat__link"  ><router-link :to="{ name: 'Layout' }"
              >
              Верстка</router-link
            >
        </a>
        <a class="cat__link"  ><router-link :to="{ name: 'Scripts' }"
              >
              Скрипты и боты</router-link
            >
        </a>
        <a class="cat__link"  ><router-link :to="{ name: 'Usability' }"
              >
              Юзабилити, тесты и помощь</router-link
            >
        </a>
        <a class="cat__link"  ><router-link :to="{ name: 'Sitesetup' }"
              >
              Доработка и настройка сайта</router-link
            >
        </a>
        <a class="cat__link"  ><router-link :to="{ name: 'Desktop' }"
              >
              Десктоп программирование</router-link
            >
        </a>
        <a class="cat__link"  ><router-link :to="{ name: 'Application' }"
              >
              Мобильные приложения</router-link
            >
        </a>
        <a class="cat__link"  ><router-link :to="{ name: 'Sitemaking' }"
              >
              Создание сайтов</router-link
            >
        </a>
        <a class="cat__link"  ><router-link :to="{ name: 'Games' }"
              >
              Игры</router-link
            >
        </a>
        <a class="cat__link"  ><router-link :to="{ name: 'Server' }"
              >
              Сервера и хостинг</router-link
            >
        </a>
        
        </div>
      </div> 
    <div class=" rubrics__items">
    <div class=" rubrics_item">
      <a class="rubrics__link"  ><router-link :to="{ name: 'Layout' }"
            >
        <img src="../images/Верстка.png" alt=""></router-link
          >
      </a>
    </div>
    <div class=" rubrics_item">
      <a class="rubrics__link" ><router-link :to="{ name: 'Scripts' }"
            >
        <img src="../images/Скрипты.png" alt=""></router-link
          >
      </a>
    </div>
    <div class=" rubrics_item">
      <a class="rubrics__link" ><router-link :to="{ name: 'Usability' }"
            >
        <img src="../images/texts.png" alt=""></router-link
          >
      </a>
    </div>
    <div class=" rubrics_item">
      <a class="rubrics__link" ><router-link :to="{ name: 'Sitesetup' }"
            >
        <img src="../images/настройкасайта.png" alt=""></router-link
          >
      </a>
    </div>
    <div class=" rubrics_item">
      <a class="rubrics__link" ><router-link :to="{ name: 'Desktop' }"
            >
        <img src="../images/Десктоп.png" alt=""></router-link
          >
      </a>
    </div>
    <div class=" rubrics_item">
      <a class="rubrics__link" ><router-link :to="{ name: 'Application' }"
            >
        <img src="../images/app.png" alt=""></router-link
          >
      </a>
    </div>
    <div class=" rubrics_item">
      <a class="rubrics__link" ><router-link :to="{ name: 'Sitemaking' }"
            >
        <img src="../images/Созданиесайтов.png" alt=""></router-link
          >
      </a>
    </div>
    <div class=" rubrics_item">
      <a class="rubrics__link" ><router-link :to="{ name: 'Games' }"
            >
        <img src="../images/game.png" alt=""></router-link
          >
      </a>
    </div>
    <div class=" rubrics_item">
      <a class="rubrics__link" ><router-link :to="{ name: 'Server' }"
            >
        <img src="../images/servera.png" alt=""></router-link
          >
      </a>
    </div>
    
  </div> 
 
</div>
 
 

</div>
  </div>
    
  
 


</template>

<script>
export default {


};
</script>

<style>
.rubrics__items{
  flex-basis: 70%;
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
.rubrics_item{
  
    box-sizing: border-box;
    padding: 6px;
    width: 25%;

  
}

.right_side_menu{
    color: rgb(0, 0, 0);
}
.design_page{
    display: flex;
    margin-top: 40px;
   
}
.col-md-8{
    width: 60vw;
}
.page__header{
  
  margin: 40px 0 34px;
    text-align: center;
}
.diz{
  display: block;
    font-size: 2em;
    margin-block-start: 0.67em;
    margin-block-end: 0.67em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}
.subcategory{
  flex-basis: 30%;
}
.card_item{
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
.subcategory-list a{
  text-decoration: none;
  list-style-type: none;
color: #333;
    display: block;
    font-size: 14px;
    line-height: 22px;
    margin-bottom: 4px;
    padding: 0 0 2px;
}
@media (min-width: 768px){
  .rubrics_item{
    width: 25%;
  }
  .col-md-12{
    display: flex;
  }
  .subcategory-list h3{
    
    color: #111;
    font-size: 22px;
    font-weight: 600;
    line-height: 28px;
    margin-bottom: 16px;
    padding: 1px 0 3px;
  }
}
@media (max-width: 768px){
  .rubrics_item{
    width: 50%;

  }
  .subcategory{
    content-visibility: hidden;
  }
}
</style>
