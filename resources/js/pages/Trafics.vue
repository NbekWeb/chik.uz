<template>
  
  <div class="container">
    <div >
   
   
    
   <div class="page__header">
   <h2 class="diz">Трафик</h2>
   
 </div>
 
 
   <div class="col-md-12">
 <h2>{{ category }} </h2>
 <div class="card_iten">
  <div class="card-blog-content" v-for="post in posts" :key="post.id">
   <img :src="post.imagePath" alt="" />
   <div class="item-content">
   
      <p class="item_title">
        <h3>{{ post.title }}</h3>
      </p>
      <div class="item-price">
        <h3>{{ post.price }}</h3> Uzs
      </div>
   
   </div>
   
   
 </div>
 </div>
 
</div>
 
 

</div>
  </div>
    
  
 


</template>

<script>
export default {
props: ['posts', 'category'],

data() {
  return {
    posts: [],
  };
},

mounted() {
  this.filterByCategory('Трафик'); // Initial load with category name 'Design'
},

methods: {
  filterByCategory(name) {
    axios
      .get("/api/posts", {
        params: {
          category: name,
        },
      })
      .then((response) => {
        this.posts = response.data.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
},
};
</script>

<style>
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
.item_title{
  
  color: #111;
    font-size: 14px;
    height: 36px;
    line-height: 18px;
    margin-bottom: 8px;
    max-height: 100%;
    min-height: auto;
    padding: 0;
}
.item-price{
  
  height: 50px;
    padding: 13px 0 0;
  color: #04b70a;
    font-size: 16px;
    font-weight: 700;
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
.card-blog-content{
  box-sizing: border-box;
    padding: 6px;
    width: 25%;
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
@media (min-width: 768px){
  .rubrics_item{
    width: 25%;
  }
}
@media (max-width: 768px){
  .rubrics_item{
    width: 50%;
  }
}
</style>
