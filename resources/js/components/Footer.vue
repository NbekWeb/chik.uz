<template>
    
</template>
<script>
//import {footerMenuList, footerListSecond, footerListThird, footerListFurth} from '../constants/menuLinks'

export default{
    /*data(){
        return{
            footerMenu: footerMenuList,
            footerSecond: footerListSecond,
            footerThird: footerListThird,
            footerFurth: footerListFurth
        }
    }*/
}
</script>
<style>
.footer {
    position: relative;
    color: #000;
    padding: 48px 0;
  
}

.footer_logo{
    width: 125px;
    height: 60px;
}
.footer__link{
        display: inline-block;
        color: #000;
        text-decoration: none;
    }
.footer__title{
        font-size: 12px;
        color: #fdfbfb;
        /*line-height: 24px;*/
        margin: 0;
        font-family: "Josefin Sans", sans-serif;
    }
.footer__title1{
        font-size: 16px;
        margin-bottom: 10px;
}
.footer_text{
        font-size: 12px;
        width: 720px;
}
@media (max-width: 768px){
    .footer_text{
        font-size: 12px;
        width: 290px;
        
} 
.footer_logo{
    position: relative;
    width: 125px;
    height: 60px;
    z-index: 40;
}
}
@media (max-width: 360px){
    .footer_text{
        font-size: 12px;
        width: 140px;
        
} 
.footer_logo{
    position: relative;
    width: 125px;
    height: 60px;
    z-index: 40;
}
}
.footer__list{
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        list-style: none;
        font-family: "Josefin Sans", sans-serif;
    }
</style>