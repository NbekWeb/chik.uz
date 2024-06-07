<template>
    <section style="background-color: #9A616D; min-height:100vh">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img2.webp"
                                    alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <div class="d-flex align-items-center mb-3 pb-1">
                                        <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                        <span class="h1 fw-bold mb-0">Chik</span>
                                    </div>
                                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Войти</h5>
                                    <form @submit.prevent="submit">

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

                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg btn-block" type="submit">Войти</button>
                                        </div>


                                        <p class="mb-5 pb-lg-2" style="color: #393f81;">Все ещё нету аккуанта? <a
                                                href="#!" style="color: #393f81;"><router-link
                                                    :to="{ name: 'Register' }">Регистрация</router-link></a></p>

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
                .post("/api/login", this.fields)
                .then(() => {
                    // this.$router.push({ name: "Dashboard" });
                    localStorage.setItem("authenticated", "true");
                    this.$emit("updateSidebar");
                    this.$router.push({ name: "Home" });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
    },
};
</script>

<style scoped></style>
