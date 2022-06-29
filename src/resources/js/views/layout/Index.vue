<template>
    <div class="mt-5">
        <router-view v-slot="{ Component }">
            <transition name="fade" appear>
                <component :is="Component" />
            </transition>
        </router-view>
    </div>
</template>

<script>
export default {
};
</script>

<style lang="scss">
body, #app {
    height: 100vh
}
.fade-enter-active {
    transition: opacity 1s ease;
}

.fade-enter-from,
.fade-leave-active {
    opacity: 0;
}
</style>
