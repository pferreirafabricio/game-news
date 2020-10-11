<template>
  <vs-prompt
    title="Delete game"
    color="danger"
    @accept="deleteGame()"
    @close="$emit('closed')"
    :active.sync="activateDialog"
    accept-text="Delete"
    text="Delete this game?"
    ref="deleteDialog"
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
    deleteGame() {
      fetch(`${this.webApiUrl}/game/${this.gameId}`, {
        method: 'DELETE',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json',
        },
      })
        .then((response) => response.json())
        .then((data) => {
          this.$vs.notify({
            color: 'success',
            title: 'Success!',
            text: data.data.message,
          });

          this.$emit('closed');
          this.$emit('delete-game');
        })
        .catch(() => {
          this.$vs.notify({
            color: 'danger',
            title: 'Oopss!',
            text: 'Something was wrong to delete this game',
          });
        });
    },
  },
};
</script>
