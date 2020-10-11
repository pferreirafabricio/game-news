<template>
  <vs-row vs-justify="space-around">
    <vs-col
      type="flex"
      class="p-3"
      vs-justify="center"
      vs-align="center"
      vs-w="3"
      vs-lg="3"
      vs-sm="12"
      v-for="(game, index) in games.data"
      :key="index"
    >
      <vs-card>
        <div slot="header">
          <h3>
            {{ game.title }}
          </h3>
        </div>
        <div slot="media">
          <!-- <iframe
            src="https://www.youtube.com/embed/X6d3AIkvID4"
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
          ></iframe> -->
        </div>
        <div>
          <span>
            {{ game.description }}
          </span>
        </div>
        <div slot="footer">
          <vs-row vs-justify="flex-end">
            <vs-button
              class="mr-1"
              color="primary"
              type="gradient"
              @click="viewGame(game.id)"
            >
              View
            </vs-button>
            <vs-button
              class="mr-1"
              color="warning"
              type="gradient"
            >
              Edit
            </vs-button>
            <vs-button
              class="mr-1"
              color="danger"
              type="gradient"
            >
              Delete
            </vs-button>
          </vs-row>
        </div>
      </vs-card>
    </vs-col>

    <ViewGame
      v-if="game.view"
      :gameId="game.selectedGameId"
      @closed="game.view = false"
    />
  </vs-row>
</template>

<script>
import ViewGame from './ViewGame.vue';

export default {
  name: 'GameCards',
  components: {
    ViewGame,
  },
  data() {
    return {
      games: [],
      game: {
        selectedGameId: 1,
        view: false,
      },
    };
  },
  computed: {
    webApiUrl: () => 'http://localhost:8080/gamenews/backend',
  },
  mounted() {
    this.loadGames();
  },
  methods: {
    async loadGames() {
      try {
        const response = await fetch(`${this.webApiUrl}/game`, {
          method: 'GET',
          headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
          },
        });

        this.games = await response.json();
      } catch (exception) {
        this.openAlert('danger', 'Oopss!', 'Something was wrong');
      }
    },
    viewGame(gameId) {
      this.game.view = true;
      this.game.selectedGameId = gameId;
    },
    openAlert(color, title, text) {
      this.colorAlert = color || 'success';
      this.$vs.dialog({
        color: this.colorAlert,
        title,
        text,
        accept: this.acceptAlert,
      });
    },
    notify(color, title, text) {
      this.$vs.notify({
        color,
        title,
        text,
      });
    },
  },
};
</script>

<style scoped>
.mr-1 {
  margin-right: .2rem;
}

.m-2 {
  padding: .8rem;
}

.p-5 {
  padding: 1.4rem;
}
</style>
