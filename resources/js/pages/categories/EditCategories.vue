<template>
    <div id="create-categories">
        <div id="contact-us">
            <h1>Изменить категорию!</h1>
            <!-- success message -->
            <div class="success-msg" v-if="success">
                <i class="fa fa-check"></i>
                Успешно обновлено
            </div>
            <div class="contact-form">
                <form @submit.prevent="submit">
                    <label for="name"><span>Название категории</span></label>
                    <input type="text" id="name" v-model="field.name" />
                    <span v-if="errors.name" class="error">{{ errors.name[0] }}</span>

                    <input type="submit" value="Сохранять" />
                </form>
            </div>
            <div class="create-categories">
                <router-link :to="{ name: 'CategoriesList' }">Список категорий<span>&#8594;</span></router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["id"],
    data() {
        return {
            field: {},
            errors: {},
            success: false,
        };
    },

    methods: {
        submit() {
            axios
                .put("/api/categories/" + this.id, this.field)
                .then(() => {
                    this.field = {};
                    this.errors = {};
                    this.success = true;

                    setInterval(() => {
                        this.success = false;
                    }, 2500);
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
    },

    mounted() {
        axios
            .get("/api/categories/" + this.id)
            .then((response) => (this.field = response.data))
            .catch((error) => {
                console.log(error);
            });
    },
};
</script>

<style scoped>
#create-categories {
    background-color: #f3f4f6;
    height: 90vh;
    padding: 50px;
}
</style>
