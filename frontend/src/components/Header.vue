<template>
  <vs-navbar color="#1E1E1E" class="header">
    <div slot="title">
      <vs-navbar-title>
        <vs-icon icon="videogame_asset"></vs-icon>
        <span class="ml-2">Gamenews</span>
      </vs-navbar-title>
    </div>

    <vs-spacer></vs-spacer>

    <vs-button @click="createNewGame = true" color="success" type="gradient">
      New Game
    </vs-button>
    <CreateGame
      :showDialog="createNewGame"
      @closed="createNewGame = false"
    />
  </vs-navbar>
</template>

<script>
import CreateGame from './Game/Create.vue';

export default {
  name: 'Header',
  components: {
    CreateGame,
  },
  data() {
    return {
      createNewGame: false,
    };
  },
};
</script>

<style>
.header {
  color: rgb(255, 255, 255);
  padding: 10px 1.4rem;
}
</style>
