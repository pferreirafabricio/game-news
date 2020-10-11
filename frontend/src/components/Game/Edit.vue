<template>
  <vs-prompt
    :title="isUpdate ? 'Edit game' : 'Create new game'"
    color="success"
    :accept-text="isUpdate ? 'Update' : 'Create'"
    @accept="isUpdate ? update() : create()"
    @close="$emit('closed')"
    @cancel="$emit('closed')"
    :active.sync="show"
    button-accept="gradient"
  >
    <section class="mb-4 mt-3">
      <vs-input
        :success="successMessages.title.success"
        :success-text="successMessages.title.text"
        :danger="errorMessages.title.error"
        :danger-text="errorMessages.title.text"
        @input="errorMessages.title.error = false"
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
        @input="errorMessages.video_id.error = false"
        color="success"
        class="mt-1"
        label-placeholder="Game's Video Id from YouTube"
        v-model="Fields.video_id"
      />
    </section>
  </vs-prompt>
</template>

<script>
// eslint-disable-next-line import/named
import { EventBus } from '../../eventBus';

export default {
  name: 'CreateGame',
  props: {
    showDialog: Boolean,
    gameId: String,
  },
  data() {
    return {
      description: {
        maxCharacters: 255,
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
    isUpdate() { return (this.gameId); },
  },
  mounted() {
    if (this.gameId) {
      this.loadGame(this.gameId);
    }
  },
  methods: {
    async loadGame(gameId) {
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
            this.Fields.title = data.data.title;
            this.Fields.description = data.data.description;
            this.Fields.video_id = data.data.video_id;
          });
      } catch (exception) {
        this.$vs.notify({
          color: 'danger',
          title: 'Oopss!',
          text: 'Something was wrong to view this game',
        });
      }
    },
    create() {
      if (this.validateFields()) {
        fetch(`${this.webApiUrl}/game`, {
          method: 'POST',
          headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(this.Fields),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.data.errcode) {
              this.$vs.notify({
                color: 'danger',
                title: 'Oopss!',
                text: data.data.message,
              });
              return;
            }

            this.$vs.notify({
              color: 'success',
              title: 'Success!',
              text: data.data.message,
            });

            this.clean();
            this.cleanMessages();
            this.$emit('closed');
            EventBus.$emit('new-game');
          })
          .catch((error) => {
            this.$vs.notify({
              color: 'danger',
              title: 'Oops!',
              text: error.response.data.message,
            });
          });
      } else {
        this.$vs.notify({
          color: 'warning',
          title: 'Oopss!',
          text: 'Verify the fields and try again',
        });
      }
    },
    update() {
      if (this.validateFields()) {
        fetch(`${this.webApiUrl}/game/${this.gameId}`, {
          method: 'PUT',
          headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(this.Fields),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.data.errcode) {
              this.$vs.notify({
                color: 'danger',
                title: 'Oopss!',
                text: data.data.message,
              });
              return;
            }

            this.$vs.notify({
              color: 'success',
              title: 'Success!',
              text: data.data.message,
            });

            this.loadGame(this.gameId);
          });
      } else {
        this.$vs.notify({
          color: 'warning',
          title: 'Oopss!',
          text: 'Verify the fields and try again',
        });
      }
    },
    validateFields() {
      // if (this.Fields.title.length < 4 || this.Fields.title.length > 100) {
      //   this.errorMessages.title.error = true;
      //   this.errorMessages.title.text = 'The title of the game is invalid';
      //   return false;
      // }

      this.successMessages.title.success = true;

      if (this.Fields.description.length < 10 || this.Fields.description.length > 255) {
        this.$vs.notify({
          color: 'danger',
          title: 'Description invalid!',
          text: 'The description have to a text between 10 and 255 characters',
        });
        return false;
      }

      if (this.Fields.video_id.length === '' || this.Fields.video_id.length <= 8) {
        this.errorMessages.video_id.error = true;
        this.errorMessages.video_id.text = 'The video id of the game is invalid';
        return false;
      }

      this.successMessages.video_id.success = true;
      this.successMessages.video_id.text = 'The title of the game is invalid';

      return true;
    },
    clean() {
      Object.entries(this.Fields).forEach(([key]) => {
        this.Fields[key] = '';
      });
    },
    cleanMessages() {
      Object.entries(this.errorMessages).forEach(([key]) => {
        this.errorMessages[key].error = false;
      });

      Object.entries(this.successMessages).forEach(([key]) => {
        this.successMessages[key].success = false;
      });
    },
  },
};
</script>

<style>
</style>
