<script setup>
import { ref, onMounted,watch } from "vue";
import axios from "axios";
import { useRoute,useRouter } from "vue-router";

const items = ref({});
const loader = ref(true);
const route = useRoute();
const router = useRouter();

const pushToMenu=(val)=>{
    router.push({
            path: `/post`,
            query: {
                category: val.toLowerCase(),
            },
        });
}

const fetchMenuList = async () => {
    try {
        const res = await axios.get("/api/menu_list");
        const menuData = res.data.data;
        const selectedCategory = menuData.find(
            (category) => category.name.toLowerCase() === route.query.category
        );

        if (selectedCategory) {
            const menuItems = {
                label: selectedCategory.name,
                children:
                    selectedCategory.submenu?.map((sub) => ({
                        label: sub.name,
                        key: sub.url_link,
                        img: sub.photo,
                    })) || [],
            };
            items.value = menuItems;
        } else {
            items.value = {}; 
                router.push({name:"NotFound"})
        
        }
    } catch (error) {
        console.log("Error fetching menu list:", error);
    } finally {
        loader.value = false;
    }
};

watch(
    () => route.query.category,
    (newCategory) => {
        fetchMenuList();
    }
);


onMounted(() => {
    fetchMenuList();
});
</script>

<template>
    <div class="container py-4   min-h-[300px] flex items-center">
        <a-spin :spinning="loader" class="w-full ">
            <a-row :gutter="[16, 24]" justify="center">
                <a-col
                    v-for="(item, i) of items.children"
                    :key="i"
                    class="relative cursor-pointer"
                    :lg="6"
                    :md="8"
                    :sm="12"
                    :xs="12"
                    @click="pushToMenu(item.label)"
                    
                    
                >
                    <span
                        class="absolute left-0 w-full px-4 font-bold text-white lg:text-2xl bottom-3 max-lg:text-xl"
                    >
                        {{ item.label }}  
                    </span>
                    <img
                        :src="item.img"
                        alt="item.label"
                        class="object-cover w-full xl:h-[300px] max-xl:h-[160px] max-lg:h-[150px] max-md:h-[110px]"
                    />
                </a-col>
            </a-row>
        </a-spin>
    </div>
</template>
<style lang=""></style>
