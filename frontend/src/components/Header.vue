<template>
  <vs-navbar
    color="#1E1E1E"
    class="header"
  >
    <div slot="title">
      <vs-navbar-title>
        <vs-icon icon="videogame_asset"></vs-icon>
        <span class="ml-2">Gamenews</span>
      </vs-navbar-title>
    </div>

    <vs-spacer></vs-spacer>

    <vs-button
      @click="activePrompt = true"
      color="success" type="gradient"
    >
     New Game
    </vs-button>

      <vs-prompt
        title="Create a new game"
        color="success"
        accept-text="Create"
        :active.sync="activePrompt"
        @accept="saveGame()"
      >
       <div class="mb-3">
        Name
        <vs-input placeholder="Game's title" v-model="game.title"/>
       </div>
       <div class="mb-3">
        <vs-textarea
          :counter="description.maxCharacters"
          label="Description "
          :counter-danger.sync="counterDanger"
          v-model="game.description"
        />
       </div>
       <div>
        Video Id
        <vs-input placeholder="Game's Video Id from YouTube" v-model="game.video_id"/>
       </div>
     </vs-prompt>
  </vs-navbar>
</template>

<script>
export default {
  data() {
    return {
      activePrompt: false,
      counterDanger: 10,
      description: {
        maxCharacters: 100,
      },
      game: {
        title: '',
        description: '',
        video_id: '',
      },
    };
  },
  methods: {
    saveGame() {
      this.$vs.notify({
        color: 'success',
        title: 'Game created!',
        text: 'Success! The game was created',
      });
    },
  },
};
</script>

<style>
.header {
  color: rgb(255,255,255);
  padding: 10px 1.4rem;
}
</style>
