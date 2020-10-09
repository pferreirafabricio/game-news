<template>
  <vs-row class="p-5" vs-justify="space-around">
    <vs-col
      type="flex"
      class="m-2"
      vs-justify="center"
      vs-align="center"
      vs-w="4"
      vs-lg="4"
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
          <img src="https://lusaxweb.github.io/vuesax/patreon/02-Vuesax-Silver-Manuel-Rovira-Luis-Daniel-Rovira-Lusax-Web-Framework-ui-components-Vue-js-nuxt-vuep.png">
        </div>
        <div>
          <span>
            {{ game.description }}
          </span>
        </div>
        <div slot="footer">
          <vs-row vs-justify="flex-end">
            <vs-button class="mr-1" color="primary" type="gradient">
              View
            </vs-button>
            <vs-button class="mr-1" color="warning" type="gradient">
              Edit
            </vs-button>
            <vs-button class="mr-1" color="danger" type="gradient">
              Delete
            </vs-button>
          </vs-row>
        </div>
      </vs-card>
    </vs-col>
  </vs-row>
</template>

<script>
export default {
  data() {
    return {
      games: [],
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
        const response = await fetch(`${this.webApiUrl}/game/`, {
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
    openAlert(color, title, text) {
      this.colorAlert = color || 'success';
      this.$vs.dialog({
        color: this.colorAlert,
        title,
        text,
        accept: this.acceptAlert,
      });
    },
    acceptAlert() {
      this.$vs.notify({
        color: this.colorAlert,
        title: 'Accept Selected',
        text: 'Lorem ipsum dolor sit amet, consectetur',
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
