<template>
  <vs-prompt
    title="Create a new game"
    color="success"
    accept-text="Create"
    @accept="saveGame()"
    @close="$emit('closed')"
    :active.sync="activateDialog"
    buttons-hidden
  >
    <div class="mb-3">
      Name
      <vs-input
        disabled
        placeholder="Game's title"
        v-model="game.title"
      />
    </div>
    <div class="mb-3">
      <vs-textarea
        label="Description "
        v-model="game.description"
        disabled
      />
    </div>
    <div>
      Video Id
      <vs-input
        placeholder="Game's Video Id from YouTube"
        v-model="game.video_id"
        disabled
      />
    </div>
  </vs-prompt>
</template>

<script>
export default {
  props: {
    gameId: {
      required: true,
    },
  },
  data() {
    return {
      game: {},
    };
  },
  computed: {
    webApiUrl: () => 'http://localhost:8080/gamenews/backend',
    activateDialog: {
      get() {
        return (this.gameId !== 0);
      },
      set(newValue) {
        return newValue;
      },
    },
  },
  mounted() {
    this.viewGame(this.gameId);
  },
  methods: {
    async viewGame(gameId) {
      try {
        await fetch(`${this.webApiUrl}/game/${gameId}`, {
          method: 'GET',
          headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
          },
        })
          .then((response) => response.json())
          .then((data) => {
            this.game = data.data;
          });
      } catch (exception) {
        this.$vs.notify({
          color: 'danger',
          title: 'Oopss!',
          text: 'Something was wrong to view this game',
        });
      }
    },
  },
};
</script>

<style>
</style>
