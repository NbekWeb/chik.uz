<template>
    <section class="topbackgroung">
        <img src="../images/homw2.jpg" alt="" class="topbackgroung">
    </section>
    <div id="backend-view">
        <!--<h1 class="heading">Dashboard</h1>-->
        <div class="dashinfo">
            <div class="userDashboard">
                <img :src="avatar ? '/storage/' + avatar : '/storage/uploads/files/avatar.png'" alt=""
                    class="userphoto">

                <div class="userinfor">
                    <span class="userName"> {{ name }}!</span>
                    <br>
                    <br>
                    <h3 class="balance"></h3> <span class="userBalance">Баланс: {{ cash }}:Uzs!</span>
                    <br>
                    <br>
                    <span class="userEmail">Email Адрес: {{ email }}</span>
                </div>

            </div>

            <div class="links">
                <ul>
                    <li>
                        <h3 class="project"></h3>
                        <router-link :to="{ name: 'CreatePosts' }">Создать Chick</router-link>
                    </li>
                    <li>
                        <h3 class="project"></h3>
                        <router-link :to="{ name: 'DashboardPostsList' }">Настройка</router-link>
                    </li>
                    <li v-if="role_id == 1">
                        <!--<h3 class="project"> Давайте создадим категории:</h3>-->
                        <router-link :to="{ name: 'CreateCategories' }">Давайте создадим категорию</router-link>
                    </li>
                    <span> <a href="orders">My Orders</a></span>

                    <!--<li>
          <h3 class="project"> Просмотр список категории:</h3>
          <router-link :to="{ name: 'CategoriesList' }"
            >Список категории</router-link
          >
        </li>-->
                </ul>
            </div>
        </div>
        <div v-if="posts.length > 0" class="container">

            <div class="card-info">
                <h3>Мои чики</h3>
                <div class="card-blog-content" v-for="post in posts" :key="post.id">
                    <div>
                        <img v-if="post.images.length > 0" :src="post.images[0]?.url" :alt="`First Image`"
                            style="width: 150px; height: 150px" />
                    </div>

                    <h4 style="font-weight: bolder">
                        <router-link :to="{
                    name: 'SingleBlog',
                    params: { slug: post.slug },
                }">{{ post.title }}</router-link>
                    </h4>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
export default {

    data() {
        return {
            posts: [],
            links: [],
            avatar: '',
            name: "",
            email: '',
            cash: 0,
            role_id: ""
        };
    },
    mounted() {
        axios
            .get("/api/user")
            .then((response) => {
                this.name = response.data.name;
                this.email = response.data.email;
                this.cash = response.data.cash;
                this.avatar = response.data.avatar;
                this.role_id = response.data.role_id;
            })

            .catch((error) => {
                if (error.response.status === 401) {
                    this.$emit("updateSidebar");
                    localStorage.removeItem("authenticated");
                    this.$router.push({ name: "Login" });
                }
            });

        axios
            .get("/api/dashboard-posts")
            .then((response) => {
                this.posts = response.data.data;
                console.log(response.data.meta.links);
                this.links = response.data.meta.links;
            })
            .catch((error) => {
                console.log(error);
            });
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
    },
};

</script>

<style scoped>
/* dashboard */
.card-info {
    margin-top: 20px;
}

.dashinfo {
    display: flex;
    margin-top: -30px;
    height: 378px;
}

.userinfor {
    margin-top: 14px;
}

.userName {
    font-size: 26px;
    color: black;
    font-family: Arial, Open Sans, sans-serif;
    margin-top: 14px;
}

.userphoto {
    background-color: #e2e2e2;
    border-radius: 4px;
    margin-top: -40px;
    width: 220px;
    /*padding: 10px;*/
    height: 230px;
}

.topbackgroung {
    display: block;
    width: 100%;
    height: 226px;
}

#backend-view {
    /*margin-top: -50px;*/
    /*display: flex;*/
    /*text-align: center;*/
    background-color: #f3f4f6;
    height: 100vh;
    /* padding-top: 15vh;*/
}

.userBalance {
    color: green;
}

.logout {
    left: 290px;
    flex-basis: 10%;
    position: relative;
    z-index: 100;
    top: 10px;
    font-size: 25px;
    color: black;
}

.heading {
    margin-bottom: 5px;
}

.links {
    flex-basis: 30%;
    /*margin-top: 30px;*/
    border: 1px solid #e2e2e2;
    /*height: 378px;*/
    margin-right: 14px;
    /*margin-left: 800px;
  margin-right: auto;*/
    background: #ffffff;
    /*max-width: 400px;*/
    padding: 15px;
    border-radius: 4px;
    color: black;
}

.userDashboard {
    border: 1px solid #e2e2e2;
    /*height: 378px;*/
    flex-basis: 70%;
    /*margin-top: 30px;*/
    margin-left: 14px;
    /*max-width: 400px;*/
    background: #ffffff;

    padding: 15px;
    border-radius: 4px;
    color: black;
}

.settingsP {
    margin-top: 30px;
    margin-left: auto;
    margin-right: 800px;
    background: #ffffff;
    max-width: 400px;
    padding: 15px;
    border-radius: 15px;
    color: black;
}

.links ul {
    list-style: none;
}

.links a {
    all: revert;
    font-size: 25px;
    display: inline-block;
    margin: 10px 0;
    color: rgb(172, 11, 164);

}

.links a:hover {
    all: revert;
    font-size: 25px;
    display: inline-block;
    margin: 10px 0;
    color: white;
    background: rgb(11, 41, 172);
}

@media (max-width: 768px) {
    .dashinfo {
        display: flex;
        margin-top: -30px;
        height: 378px;
    }

    .userDashboard {
        flex-basis: 70%;
        /*margin-top: 30px;*/
        margin-left: 20px;
        /*margin-right: 20px;*/
        background: #ffffff;

        padding: 15px;
        border-radius: 15px;
        color: black;
    }

    .links {
        flex-basis: 30%;
        /*margin-top: 30px;*/
        /*margin-left: 800px;
  margin-right: auto;*/
        background: #ffffff;
        /*max-width: 400px;*/
        padding: 15px;
        border-radius: 15px;
        color: black;
    }

    .links ul {
        list-style: none;
    }

    .links a {
        all: revert;
        font-size: 16px;
        display: inline-block;
        margin: 10px 0;
        color: rgb(172, 11, 164);

    }

    .links a:hover {
        all: revert;
        font-size: 16px;
        display: inline-block;
        margin: 10px 0;
        color: white;
        background: rgb(11, 41, 172);
    }

    .project {
        font-size: 16px;
    }

    .logout {
        left: -9px;
        flex-basis: 20%;
        position: relative;
        /*z-index: 100;*/
        top: 0px;
        font-size: 17px;
        color: black;
    }
}

@media (max-width: 360px) {
    .userDashboard {
        flex-basis: 70%;
        /*margin-top: 30px;*/
        margin-left: 20px;
        margin-right: 20px;
        background: #ffffff;
        max-width: 200px;
        padding: 15px;
        border-radius: 15px;
        color: black;
    }

    .links {
        flex-basis: 30%;
        margin-top: 30px;
        /*margin-left: 800px;
  margin-right: auto;*/
        background: #ffffff;
        max-width: 400px;
        padding: 15px;
        border-radius: 15px;
        color: black;
    }

    .links ul {
        list-style: none;
    }

    .links a {
        all: revert;
        font-size: 16px;
        display: inline-block;
        margin: 10px 0;
        color: rgb(172, 11, 164);

    }

    .links a:hover {
        all: revert;
        font-size: 16px;
        display: inline-block;
        margin: 10px 0;
        color: white;
        background: rgb(11, 41, 172);
    }

    .project {
        font-size: 16px;
    }

    .logout {
        left: -9px;
        flex-basis: 20%;
        position: relative;
        /*z-index: 100;*/
        top: 0px;
        font-size: 17px;
        color: black;
    }
}
</style>
