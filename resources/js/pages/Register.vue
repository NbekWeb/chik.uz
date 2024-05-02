<template>

    <!-- Section: Design Block -->
    <section class="h-100 bg-dark">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card card-registration my-4">
                        <div class="row g-0">
                            <div class="col-xl-6 d-none d-xl-block">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/img4.webp"
                                    alt="Sample photo" class="img-fluid"
                                    style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;" />
                            </div>
                            <div class="col-xl-6">
                                <div class="card-body p-md-5 text-black">
                                    <h3 class="mb-5 text-lowcase">Регистрация</h3>
                                    <form @submit.prevent="submit">

                                        <div class="form-outline mb-4">
                                            <input type="name" id="name" v-model="fields.name"
                                                class="form-control form-control-lg" />
                                            <label class="form-label" for="name">Имя</label>
                                            <span v-if="errors.name" class="error">{{ errors.name[0] }}</span>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="email" id="email" v-model="fields.email"
                                                class="form-control form-control-lg" />
                                            <label class="form-label" for="email">Email адрес</label>
                                            <span v-if="errors.email" class="error">{{ errors.email[0] }}</span>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="password" id="password" v-model="fields.password"
                                                class="form-control form-control-lg" />
                                            <label class="form-label" for="password">Пароль</label>
                                            <span v-if="errors.password" class="error">{{ errors.password[0] }}</span>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="password" id="password_confirmation"
                                                v-model="fields.password_confirmation"
                                                class="form-control form-control-lg" />
                                            <label class="form-label" for="password_confirmation">Подтвердите
                                                Пароль</label>
                                            <span v-if="errors.password_confirmation" class="error">{{
                                                errors.password_confirmation[0] }}</span>
                                        </div>

                                        <div class="d-flex justify-content-end pt-3">

                                            <button type="submit"
                                                class="btn btn-warning btn-lg ms-2">Регистрация</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            fields: {},
            errors: {},
        };
    },
    methods: {
        submit() {
            axios
                .post("/api/register", this.fields)
                .then(() => {
                    this.$router.push({ name: "Dashboard" });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
    },
};
</script>

<style scoped>
.background-radial-gradient {
    background-color: hsl(218, 41%, 15%);
    background-image: radial-gradient(650px circle at 0% 0%,
            hsl(218, 41%, 35%) 15%,
            hsl(218, 41%, 30%) 35%,
            hsl(218, 41%, 20%) 75%,
            hsl(218, 41%, 19%) 80%,
            transparent 100%),
        radial-gradient(1250px circle at 100% 100%,
            hsl(218, 41%, 45%) 15%,
            hsl(218, 41%, 30%) 35%,
            hsl(218, 41%, 20%) 75%,
            hsl(218, 41%, 19%) 80%,
            transparent 100%);
}

#radius-shape-1 {
    height: 220px;
    width: 220px;
    top: -60px;
    left: -130px;
    background: radial-gradient(#44006b, #ad1fff);
    overflow: hidden;
}

#radius-shape-2 {
    border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
    bottom: -60px;
    right: -110px;
    width: 300px;
    height: 300px;
    background: radial-gradient(#44006b, #ad1fff);
    overflow: hidden;
}

.bg-glass {
    background-color: hsla(0, 0%, 100%, 0.9) !important;
    backdrop-filter: saturate(200%) blur(25px);
}
</style>
