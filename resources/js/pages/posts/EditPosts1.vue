<template>
    <main class="create-post">
        <div class="container">
            <h1>Изменить Chik!</h1>
            <!-- success message -->
            <div class="success-msg" v-if="success">
                <i class="fa fa-check"></i>
                Chik изменён успешно !
            </div>
            <!-- Contact Form -->
            <div class="contact-form">
                <form class="titlinput" @submit.prevent="submit">
                    <!-- Title -->
                    <label for="title"><span>Заголовок</span></label>
                    <input type="text" id="title" v-model="fields.title" />
                    <span v-if="errors.title" class="error">{{
                        errors.title[0]
                    }}</span>
                    <br />

                    <!-- Image -->
                    <label for="image"><span>Фото</span></label>
                    <input type="file" id="image" @change="grabFile" accept="image/*" multiple />
                    <span v-if="errors.file" class="error">{{
                        errors.file[0]
                    }}</span>
                    <div class="preview" v-if="urls.length > 0">
                        <div v-for="(url, index) in urls" :key="index">
                            <img :src="url" alt="" />
                        </div>
                    </div>
                    <br />

                    <!-- Drop down -->
                    <label for="categories"><span>Выберите категорию:</span></label>
                    <select v-model="fields.category_id" id="categories">
                        <option disabled value="">Категории</option>
                        <option :value="category.id" v-for="category in categories" :key="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                    <span v-if="errors.category_id" class="error">{{
                        errors.category_id[0]
                    }}</span>
                    <br />

                    <!-- Price -->
                    <label for="price"><span>Цена</span></label>
                    <input type="text" id="price" v-model="fields.price" />
                    <span v-if="errors.price" class="error">{{ errors.price[0] }}</span>
                    <br />

                    <!-- Body-->
                    <label for="body"><span>Описание</span></label>
                    <textarea id="body" v-model="fields.body"></textarea>
                    <span v-if="errors.body" class="error">{{
                        errors.body[0]
                    }}</span>
                    <!-- Button -->
                    <input class="add-post-btn" type="submit" value="Изменить" />
                </form>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    props: ["slug"],
    data() {
        return {
            success: false,
            fields: {
                category_id: "",
            },
            errors: {},
            urls: [],
            categories: [],
            images: [],
        };
    },

    methods: {
        grabFile(e) {
            const files = e.target.files;
            this.images = [];
            this.urls = [];

            if (files.length < 3 || files.length > 3) {
                alert("Допускается минимум 3 фото.");
                e.target.value = "";
                return;
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                this.images.push(file);
                const reader = new FileReader();
                reader.onload = (e) => {
                    const url = e.target.result;
                    this.urls.push(url);
                };
                reader.readAsDataURL(file);
            }
        },

        submit() {
            const fd = new FormData();
            fd.append("title", this.fields.title);
            fd.append("category_id", this.fields.category_id);
            if (this.fields.file) {
                fd.append("file", this.fields.file);
            }
            this.images.forEach((image, index) => {
                fd.append(`images[${index}]`, image);
            });
            fd.append("body", this.fields.body);

            fd.append("_method", "PUT");
            axios
                .post(`/api/posts/${this.slug}`, fd, {
                    headers: {
                        "content-type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    this.$emit("showEditSuccess");

                    this.$router.push({ name: "DashboardPostsList" });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    if (error.response.status === 403) {
                        this.$router.push({ name: "DashboardPostsList" });
                    }
                });
        },
    },

    mounted() {
        axios
            .get("/api/categories")
            .then((response) => (this.categories = response.data))
            .catch((error) => {
                console.log(error);
            });

        axios
            .get("/api/posts/" + this.slug)
            .then((response) => {
                this.fields = response.data.data;
                this.url = "/" + response.data.data.imagePath;
            })
            .catch((error) => {
                if (error.response.status === 403) {
                    this.$router.push({ name: "DashboardPostsList" });
                }
            });
    },
};
</script>

<style scoped>
.create-post {
    background-color: #fff;
    padding: 0 3vw;
}

.container input,
textarea,
select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 20px;
    font-size: 16px;
}

h1 {
    text-align: center;
    padding: 60px 0 50px 0;
}

.add-post-btn {
    background-color: #e4606d;
    color: white;
    border: none;
    cursor: pointer;
    transition: 0.3s ease;
}

.add-post-btn:hover {
    transform: translateY(-4px);
}

.preview img {
    max-width: 100%;
    max-height: 120px;
}

.titlinput {
    width: 400px;
}

@media (max-width: 380px) {
    .titlinput {
        width: 250px;
    }
}
</style>