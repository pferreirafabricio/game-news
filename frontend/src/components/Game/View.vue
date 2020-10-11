<template>
  <vs-prompt
    title="View game"
    color="success"
    accept-text="Create"
    @accept="saveGame()"
    @close="$emit('closed')"
    :active.sync="activateDialog"
    buttons-hidden
  >
    <section class="mb-3">
      <h2 class="">
        {{ game.title }}
      </h2>
    </section>
    <section class="mb-3">
      <span class="font-weight-bold">Video</span>
      <div class="text-center">
        <iframe
          :src="`https://www.youtube.com/embed/${game.video_id}`"
          frameborder="0"
          allow="
            accelerometer;
            autoplay;
            clipboard-write;
            encrypted-media;
            gyroscope;
            picture-in-picture
          "
          allowfullscreen
          ></iframe>
      </div>
    </section>
    <section class="mb-3">
      <span class="font-weight-bold">Description</span>
      <div>
        {{ game.description }}
      </div>
    </section>
    <section>
      <span class="font-weight-bold">Video Id</span>
      <div>
        {{ game.video_id }}
      </div>
    </section>
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
    viewGame(gameId) {
      fetch(`${this.webApiUrl}/game/${gameId}`, {
        method: 'GET',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json',
        },
      })
        .then((response) => response.json())
        .then((data) => {
          this.game = data.data;
        })
        .catch(() => {
          this.$vs.notify({
            color: 'danger',
            title: 'Oopss!',
            text: 'Something was wrong to view this game',
          });
        });
    },
  },
};
</script>

<style>
</style>
