<template>
  <vs-prompt
    title="Delete game"
    color="danger"
    @accept="deleteGame()"
    @close="$emit('closed')"
    :active.sync="activateDialog"
    accept-text="Delete"
    text="Delete this game?"
  ></vs-prompt>
</template>

<script>
export default {
  props: {
    gameId: {
      required: true,
    },
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
  methods: {
    async deleteGame() {
      try {
        await fetch(`${this.webApiUrl}/game/${this.gameId}`, {
          method: 'DELETE',
          headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
          },
        })
          .then(() => {
            this.$vs.notify({
              color: 'success',
              title: 'Success!',
              text: 'Game deleted successfuly!',
            });
          });
      } catch (exception) {
        this.$vs.notify({
          color: 'danger',
          title: 'Oopss!',
          text: 'Something was wrong to delete this game',
        });
      }
    },
  },
};
</script>
