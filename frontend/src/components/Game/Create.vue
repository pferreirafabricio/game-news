<template>
  <vs-prompt
    title="Create new game"
    color="success"
    accept-text="Create"
    @accept="create()"
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
export default {
  name: 'CreateGame',
  props: {
    showDialog: Boolean,
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
  },
  methods: {
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
            this.$vs.notify({
              color: 'success',
              title: 'Success!',
              text: data.data.message,
            });
            this.clean();
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
    validateFields() {
      if (this.Fields.title.length < 4 || this.Fields.title.length > 100) {
        this.errorMessages.title.error = true;
        this.errorMessages.title.text = 'The title of the game is invalid';
        return false;
      }

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
  },
};
</script>

<style>
</style>
