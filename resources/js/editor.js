/**------------------------------------------------------------
 * editor.js
 * Ian Kollipara
 *
 * Description: This file is the editor.js file for the editor
 * component. It is responsible for initializing the editor
 * and setting up the tools for the editor. It also contains
 * the methods for persisting deleted images and saving the
 * editor content.
 *------------------------------------------------------------**/

async function configureTools(
    canUpload,
    csrf,
    imagesToDelete,
    attachesToDelete,
) {
    return await Promise.all([
        import("@editorjs/header"),
        import("@editorjs/delimiter"),
        import("@editorjs/nested-list"),
        import("@editorjs/quote"),
        import("@editorjs/embed"),
        import("@editorjs/table"),
        import("@editorjs/code"),
        import("@editorjs/underline"),
        import("@editorjs/text-variant-tune"),
        canUpload
            ? import("./image-override")
            : Promise.resolve({ default: null }),
        canUpload
            ? import("./attaches-override")
            : Promise.resolve({ default: null }),
    ]).then(
        ([
            { default: header },
            { default: delimiter },
            { default: list },
            { default: quote },
            { default: embed },
            { default: table },
            { default: code },
            { default: underline },
            { default: textVariantTune },
            { default: image },
            { default: attaches },
        ]) => ({
            header,
            delimiter,
            list,
            quote,
            table,
            code,
            underline,
            embed: {
                class: embed,
                config: {
                    services: {
                        youtube: true,
                        imgur: true,
                        pintrest: true,
                        scratch: {
                            regex: /https?:\/\/scratch.mit.edu\/projects\/(\d+)/,
                            embedUrl:
                                "https://scratch.mit.edu/projects/<%= remote_id %>/embed",
                            html: "<iframe height='300' scrolling='no' frameborder='no' allowtransparency='true' allowfullscreen='true' style='width: 100%;'></iframe>",
                        },
                    },
                },
            },
            textVariantTune,
            image: canUpload
                ? {
                      class: image,
                      config: {
                          imagesToDelete,
                          endpoints: {
                              byFile: route("upload.store"),
                              byUrl: route("upload.store"),
                          },
                          additionalRequestHeaders: {
                              "X-CSRF-TOKEN": csrf,
                          },
                      },
                  }
                : null,
            attaches: canUpload
                ? {
                      class: attaches,
                      config: {
                          attachesToDelete,
                          endpoint: route("upload.store"),
                          additionalRequestHeaders: {
                              "X-CSRF-TOKEN": csrf,
                          },
                      },
                  }
                : null,
        }),
    );
}

export default ({
    name,
    readOnly = false,
    canUpload = true,
    csrf,
    body = { blocks: [] },
}) => ({
    init() {
        this.body = body;
        if (typeof body === "object") {
            this.body = JSON.stringify(body);
        }
    },
    name,
    input: {
        ["x-model"]: "body",
        ["x-ref"]: name,
        type: "hidden",
        name,
    },
    editor: {
        class: "content is-medium editor",
        ["x-ref"]: `${name}-editor`,
        ["x-data"]() {
            const that = this;
            return {
                async init() {
                    this.imagesToDelete = [];
                    this.attachesToDelete = [];
                    Promise.all([
                        import("@editorjs/editorjs"),
                        configureTools(
                            canUpload,
                            csrf,
                            this.imagesToDelete,
                            this.attachesToDelete,
                        ),
                    ]).then(([{ default: EditorJS }, tools]) => {
                        this.tools = tools;
                        this.editor = new EditorJS({
                            readOnly,
                            holder: this.$el,
                            data: JSON.parse(that.body),
                            placeholder: readOnly ? "" : "Write your story...",
                            tools: this.tools,
                            tunes: ["textVariantTune"],
                            onReady: () => {
                                this.$dispatch(`editor-${this.name}-ready`);
                            },
                            onChange: async (api, event) => {
                                const data = await api.saver.save();
                                that.body = JSON.stringify(data);
                                that.$dispatch("editor:unsaved");
                                that.$dispatch("input", JSON.stringify(data));
                            },
                        });
                    });
                },
                destroy() {
                    this.editor.destroy();
                },
            };
        },
        [`x-on:editor-${name}-persisted`]() {
            if (canUpload) {
                Promise.allSettled([
                    ...this.imagesToDelete.map((path) =>
                        fetch(route("upload.destroy"), {
                            method: "DELETE",
                            body: JSON.stringify({ path }),
                        }),
                    ),
                    ...this.attachesToDelete.map((path) =>
                        fetch(route("upload.destroy"), {
                            method: "DELETE",
                            body: JSON.stringify({ path }),
                        }),
                    ),
                ]).finally(() => {
                    this.imagesToDelete.length = 0;
                    this.attachesToDelete.length = 0;
                });
            }
        },
    },
});
