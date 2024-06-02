<template>
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content text-center">
                    <h2>{{ heading }}</h2>
                    <div class="page_link">
                        <nuxt-link to="/">Home</nuxt-link>
                        <nuxt-link :to="routeName">{{ heading }}</nuxt-link>
                        <nuxt-link v-if="subRouteName && subHeading" :to="subRouteName">{{ subHeading }}</nuxt-link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
defineProps({
    heading: String,
    routeName: String,
    subHeading: String,
    subRouteName: String
});
</script>