<template>
  <div id="app">
    <GameCards />
  </div>
</template>

<script>
import GameCards from './components/GameCards.vue';

export default {
  name: 'App',
  components: {
    GameCards,
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
