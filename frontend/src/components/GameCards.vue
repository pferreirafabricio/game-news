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
      v-for="(game, index) in games"
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
              @click="deleteGame(game.id)"
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

    <DeleteGame
      v-if="game.delete"
      :gameId="game.selectedGameId"
      @closed="game.delete = false"
    />
  </vs-row>
</template>

<script>
import ViewGame from './ViewGame.vue';
import DeleteGame from './DeleteGame.vue';

export default {
  name: 'GameCards',
  components: {
    ViewGame,
    DeleteGame,
  },
  data() {
    return {
      games: [],
      game: {
        selectedGameId: 0,
        view: false,
        delete: false,
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
        await fetch(`${this.webApiUrl}/game`, {
          method: 'GET',
          headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
          },
        })
          .then((response) => response.json())
          .then((data) => {
            this.games = data.data;
          });
      } catch (exception) {
        this.notify(
          'danger',
          'Oopss!',
          'Something was wrong on loading the games',
        );
      }
    },
    viewGame(gameId) {
      this.game.view = true;
      this.game.selectedGameId = gameId;
    },
    deleteGame(gameId) {
      this.game.delete = true;
      this.game.selectedGameId = gameId;
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
