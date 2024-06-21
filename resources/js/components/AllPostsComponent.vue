<script setup>
import { ref, onMounted, watch, onUnmounted } from "vue";
import axios from "axios";

onMounted(() => {
    axios
        .get("/api/menu_list")
        .then((res) => {
            const menuItems = [];
            for (let i = 0; i < res.data.data.length; i++) {
                const item = {
                    label: res.data.data[i].name,
                    key: res.data.data[i].url_link,
                    children: [],
                };
                if (
                    res.data.data[i].submenu &&
                    res.data.data[i].submenu.length > 0
                ) {
                    item.children.push({
                        label: "Oбщий",
                        key: res.data.data[i].url_link,
                    });
                    for (let j = 0; j < res.data.data[i].submenu.length; j++) {
                        item.children.push({
                            label: res.data.data[i].submenu[j].name,
                            key: res.data.data[i].submenu[j].url_link,
                            img: res.data.data[i].submenu[j].photo,

                        });
                    }
                }
                menuItems.unshift(item);
            }
            items.value = menuItems;
        })
        .catch((error) => {
            console.error("Error fetching menu list:", error);
        });
});
</script>

<template>
    <div></div>
</template>
<style lang=""></style>
