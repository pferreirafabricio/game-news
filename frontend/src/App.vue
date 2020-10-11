<template>
  <div id="app">
    <Header />
    <GameCards />
  </div>
</template>

<script>
import GameCards from './components/Game/Cards.vue';
import Header from './components/Header.vue';

export default {
  name: 'App',
  components: {
    Header,
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
}

.font-weight-bold {
  font-weight: bold;
}
</style>
