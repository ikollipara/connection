/**------------------------------------------------------------
 * slim-select.js
 * Ian Kollipara
 *
 * Description: This is a wrapper around the SlimSelect library.
 * It integrates its usage with Alpine.js.
 *------------------------------------------------------------**/

import { AlpineComponent } from "alpinejs";
import type SlimSelect from "slim-select";

// TODO: Remove placeholder from the select element once all components are updated to use the placeholder attribute
export default (placeholder = "", name = "", settings = {}, search = null): AlpineComponent<{slimSelect?: SlimSelect, name: string}> => ({
  name,
  init() {
    import("slim-select").then(({ default: SlimSelect }) => {
        if(search) {
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
      })

        }
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
        },
      });
    });
  },

  destroy() {
    this.slimSelect?.destroy();
  },
});
