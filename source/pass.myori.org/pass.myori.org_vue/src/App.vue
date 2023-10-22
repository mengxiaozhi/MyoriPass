<script>
import Header_vue from './components/header.vue'
export default {
  components: {
    Header_vue,
  }
}
</script>

<template>
  <Header_vue />
  <section>
    <div id="page-wrapper">
      <div style="padding-top: 100px;">
        <router-view />
      </div>
    </div>
  </section>
</template>