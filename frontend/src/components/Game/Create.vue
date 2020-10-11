<template>
  <vs-prompt
    title="Create new game"
    color="success"
    accept-text="Create"
    @accept="saveGame()"
    @close="$emit('closed')"
    @cancel="$emit('closed')"
    :active.sync="show"
    button-accept="gradient"
    button-cancel="gradient"
  >
    <section class="mb-4 mt-3">
      <vs-input
        :success="successMessages.title.success"
        :success-text="successMessages.title.text"
        :danger="errorMessages.title.error"
        :danger-text="errorMessages.title.text"
        color="success"
        class="mt-1"
        label-placeholder="Game's title"
        v-model="Fields.title"
      />
    </section>
    <section class="mb-4">
      <vs-textarea
        :counter="description.maxCharacters"
        label="Description "
        :counter-danger.sync="description.counterDanger"
        v-model="Fields.description"
      />
    </section>
    <section>
      <vs-input
        :success="successMessages.video_id.success"
        :success-text="successMessages.video_id.text"
        :danger="errorMessages.video_id.error"
        :danger-text="errorMessages.video_id.text"
        color="success"
        class="mt-1"
        label-placeholder="Game's Video Id from YouTube"
        v-model="Fields.video_id"
      />
    </section>
  </vs-prompt>
</template>

<script>
export default {
  name: 'CreateGame',
  props: {
    showDialog: Boolean,
  },
  data() {
    return {
      description: {
        maxCharacters: '100',
        counterDanger: false,
      },
      successMessages: {
        title: {
          success: false,
          text: 'The title is valid',
        },
        video_id: {
          success: false,
          text: 'The video Id is valid',
        },
      },
      errorMessages: {
        title: {
          error: false,
          text: 'Type a valid title, please',
        },
        video_id: {
          error: false,
          text: 'Type a valid video id, please',
        },
      },
      Fields: {
        title: '',
        description: '',
        video_id: '',
      },
    };
  },
  computed: {
    webApiUrl: () => 'http://localhost:8080/gamenews/backend',
    show: {
      get() {
        return this.showDialog;
      },
      set(newValue) {
        return newValue;
      },
    },
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
