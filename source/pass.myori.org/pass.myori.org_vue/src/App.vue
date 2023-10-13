<script>
import Header_vue from './components/header.vue'
import Home from './page/home.vue'
export default {
  components: {
    Header_vue,
    Home,
  }
}
</script>

<template>
    <header_vue/>
    <section>
        <div style="padding-top: 100px;">
            <transition name="fade" mode="out-in">
              <router-view></router-view>
            </transition>
        </div>
    </section>
</template>

<style>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>