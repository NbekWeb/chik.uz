<template>
    <div id="create-categories">
        <div id="contact-us">
            <h1>Создать новую категорию!</h1>
            <!-- success message -->
            <div class="success-msg" v-if="success">
                <i class="fa fa-check"></i>
                Категория успешно создана
            </div>
            <div class="contact-form">
                <form @submit.prevent="submit">
                    <label for="name"><span>Название</span></label>
                    <input type="text" id="name" v-model="field.name" />
                    <span v-if="errors.name" class="error">{{ errors.name[0] }}</span>

                    <label for="photo"><span>Изображение</span></label>
                    <input type="file" accept="image/*" id="photo" @change="onFileChange" />
                    <span v-if="errors.photo" class="error">{{ errors.photo }}</span>

                    <label for="menu_id"><span>Menu Id</span></label>
                    <input type="text" id="menu_id" value="1" v-model="field.menu_id" />
                    <span v-if="errors.menu_id" class="error">{{ errors.menu_id[0] }}</span>

                    <input type="submit" value="Добавить" />
                </form>
            </div>
            <div class="create-categories">
                <router-link :to="{ name: 'CategoriesList' }">Список категорий <span>&#8594;</span></router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            field: {
                name: '',
                menu_id: '',
            },
            photo: null,
            errors: {},
            success: false,
        };
    },
    methods: {
        onFileChange(event) {
            const file = event.target.files[0];
            if (!file) {
                this.errors.photo = 'Изображение обязательно';
                return;
            }
            if (!file.type.startsWith('image/')) {
                this.errors.photo = 'Файл должен быть изображением';
                this.photo = null;
            } else {
                this.errors.photo = '';
                this.photo = file;
            }
        },
        submit() {
            const formData = new FormData();
            formData.append('name', this.field.name);
            formData.append('menu_id', this.field.menu_id);
            if (this.photo) {
                formData.append('photo', this.photo);
            }

            axios
                .post('/api/categories/create', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                })
                .then(() => {
                    this.field = {
                        name: '',
                        menu_id: '',
                    };
                    this.photo = null;
                    this.errors = {};
                    this.success = true;

                    setTimeout(() => {
                        this.success = false;
                    }, 2500);
                })
                .catch((error) => {
                    if (error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.error('An error occurred:', error);
                    }
                });
        },
    },
};
</script>

<style scoped>
#create-categories {
    background-color: #f3f4f6;
    height: 90vh;
    padding: 50px;
}

.success-msg {
    color: green;
}

.error {
    color: red;
}
</style>
