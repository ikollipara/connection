/**------------------------------------------------------------
 * filepond.js
 * Ian Kollipara
 *
 * Filepond configuration for Alpine.js
 *------------------------------------------------------------**/

import "filepond/dist/filepond.min.css";

export default () => ({
  init() {
    Promise.allSettled([
      import("filepond"),
      import("filepond-plugin-image-preview"),
      import("filepond-plugin-file-validate-type"),
    ]).then(
      ([
        { create, registerPlugin, destroy },
        { default: FilePondPluginImagePreview },
        { default: FilePondPluginFileValidateType },
      ]) => {
        registerPlugin(FilePondPluginImagePreview);
        registerPlugin(FilePondPluginFileValidateType);

        this.filepond = create(this.$el, {
          storeAsFile: true,
          files: $this.$el.value ?? [],
        });

        this.destroy = () => destroy(this.filepond);
      },
    );
  },
});
