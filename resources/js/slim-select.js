/**------------------------------------------------------------
 * slim-select.js
 * Ian Kollipara
 *
 * Description: This is a wrapper around the SlimSelect library.
 * It integrates its usage with Alpine.js.
 *------------------------------------------------------------**/

// TODO: Remove placeholder from the select element once all components are updated to use the placeholder attribute
export default (placeholder = "", name = "", settings = {}, search = null) => ({
  name,
  init() {
    import("slim-select").then(({ default: SlimSelect }) => {
      this.slimSelect = new SlimSelect({
        select: this.$el,
        settings: {
          placeholderText: placeholder,
          ...settings,
        },
        events: {
          error: (error) => {
            this.$dispatch(`${name}:error`, error);
          },
          afterChange: (newVal) => {
            this.$dispatch(`${name}:change`, newVal);
          },
          search,
        },
      });
    });
  },

  destroy() {
    this.slimSelect.destroy();
  },
});
