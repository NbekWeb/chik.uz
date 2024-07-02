<template>
    <a-spin :spinning="loading" >
    <section style="background-color: #9a616d; min-height: 100vh">
        <div class="container py-5 h-100">
            <div
                class="row d-flex justify-content-center align-items-center h-100"
            >
                <div class="col col-xl-10">
                    
                        <div
                            class="bg-white rounded-2xl"
                        >
                            <div class="row g-0">
                                <div
                                    class="col-md-6 col-lg-5 d-none d-md-block"
                                >
                                    <img
                                        src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img2.webp"
                                        alt="login form"
                                        class="img-fluid"
                                        style="border-radius: 1rem 0 0 1rem"
                                    />
                                </div>
                                <div
                                    class="col-md-6 col-lg-7 d-flex align-items-center"
                                >
                                    <div
                                        class="p-4 text-black card-body p-lg-5"
                                    >
                                        <div
                                            class="pb-1 mb-3 d-flex align-items-center"
                                        >
                                            <i
                                                class="fas fa-cubes fa-2x me-3"
                                                style="color: #ff6219"
                                            ></i>
                                            <span class="mb-0 h1 fw-bold"
                                                >Chik</span
                                            >
                                        </div>
                                        <h5
                                            class="pb-3 mb-3 fw-normal"
                                            style="letter-spacing: 1px"
                                        >
                                            Войти
                                        </h5>
                                        <form @submit.prevent="submit">
                                            <div class="mb-4 form-outline">
                                                <input
                                                    type="email"
                                                    id="email"
                                                    v-model="fields.email"
                                                    class="form-control form-control-lg"
                                                />
                                                <label
                                                    class="form-label"
                                                    for="email"
                                                    >Email адрес</label
                                                >
                                                <span
                                                    v-if="errors.email"
                                                    class="error"
                                                    >{{ errors.email[0] }}
                                                </span>
                                            </div>

                                            <div class="mb-4 form-outline">
                                                <input
                                                    type="password"
                                                    id="password"
                                                    v-model="fields.password"
                                                    class="form-control form-control-lg"
                                                />
                                                <label
                                                    class="form-label"
                                                    for="password"
                                                    >Пароль</label
                                                >
                                                <span
                                                    v-if="errors.password"
                                                    class="error"
                                                    >{{
                                                        errors.password[0]
                                                    }}</span
                                                >
                                            </div>

                                            <div class="pt-1 mb-4">
                                                <button
                                                    class="btn btn-dark btn-lg btn-block"
                                                    type="submit"
                                                >
                                                    Войти
                                                </button>
                                            </div>

                                            <p
                                                class="mb-5 pb-lg-2"
                                                style="color: #393f81"
                                            >
                                                Все ещё нету аккуанта?
                                                <a
                                                    href="#!"
                                                    style="color: #393f81"
                                                    ><router-link
                                                        :to="{
                                                            name: 'Register',
                                                        }"
                                                        >Регистрация</router-link
                                                    ></a
                                                >
                                            </p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                   
                </div>
            </div>
        </div>
    </section>
</a-spin>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

const fields = ref({ email: "", password: "" });
const errors = ref({});
const router = useRouter();
const loading = ref(false);

const submit = () => {
    loading.value = true;
    axios
        .post("/login", fields.value)
        .then(() => {
            localStorage.setItem("authenticated", "true");
            window.location.href = "/admin/dashboard";
            // router.push({ name: "Home" });
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            loading.value = false;
        });
};
</script>

<style scoped></style>
