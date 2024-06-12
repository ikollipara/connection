
// export default (readOnly, cannotUpload, csrf, body) => ({
//         async init() {
//             this.imagesToDelete = [];
//             this.attachesToDelete = [];
//             await Promise.all([
//                 /* webpackPreload: true */ import("@editorjs/editorjs"),
//                 import("@editorjs/header"),
//                 import("./attaches-override"),
//                 import("@editorjs/delimiter"),
//                 import("@editorjs/embed"),
//                 import("./image-override"),
//                 import("@editorjs/nested-list"),
//                 import("@editorjs/quote"),
//                 import("@editorjs/table"),
//                 import("@editorjs/text-variant-tune"),
//                 import("@editorjs/underline"),
//                 import("@editorjs/code")
//             ]).then(
//                 ([
//                     { default: EditorJS },
//                     { default: header },
//                     { default: attaches },
//                     { default: delimiter },
//                     { default: embed },
//                     { default: image },
//                     { default: list },
//                     { default: quote },
//                     { default: table },
//                     { default: textVariantTune },
//                     { default: underline },
//                     { default: code }
//                 ]) => {
//                     const tools = {
//                         header,
//                         delimiter,
//                         list,
//                         quote,
//                         table,
//                         code,
//                         underline,
//                         embed: {
//                             class: embed,
//                             config: {
//                                 services: {
//                                     youtube: true,
//                                     imgur: true,
//                                     pintrest: true,
//                                     scratch: {
//                                         regex: /https?:\/\/scratch.mit.edu\/projects\/(\d+)/,
//                                         embedUrl:
//                                             "https://scratch.mit.edu/projects/<%= remote_id %>/embed",
//                                         html: "<iframe height='300' scrolling='no' frameborder='no' allowtransparency='true' allowfullscreen='true' style='width: 100%;'></iframe>",
//                                     },
//                                 },
//                             },
//                         },
//                         textVariantTune,
//                     };
//                     if (!cannotUpload) {
//                         tools["image"] = {
//                             class: image,
//                             config: {
//                                 endpoints: {
//                                     byFile: route('upload.store'),
//                                     byUrl: route('upload.store'),
//                                 },
//                                 additionalRequestHeaders: {
//                                     "X-CSRF-TOKEN": csrf,
//                                 },
//                                 imagesToDelete: this.imagesToDelete,
//                             },
//                         };
//                         tools["attaches"] = {
//                             class: attaches,
//                             config: {
//                                 endpoint: route('upload.store'),
//                                 additionalRequestHeaders: {
//                                     "X-CSRF-TOKEN": csrf,
//                                 },
//                                 attachesToDelete: this.attachesToDelete,
//                             },
//                         };
//                     }
//                     this.editor = new EditorJS({
//                         holder: this.$el,
//                         data: body,
//                         placeholder: "Write your story...",
//                         readOnly,
//                         tools,
//                         tunes: ["textVariantTune"],
//                         onChange: async (api, event) => {
//                             this.$dispatch("editor-changed");
//                             console.log(event);
//                             console.log(this.imagesToDelete);
//                             this.body = JSON.stringify(await api.saver.save());
//                         },
//                     });
//                 }
//             );
//         },



//         async save() {
//             return await this.editor.save();
//         },

//         async destroy() {
//             this.editor.destroy();
//         }
//     });


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

import EditorJS from "@editorjs/editorjs";
import header from "@editorjs/header";
import attaches from "./attaches-override";
import delimiter from "@editorjs/delimiter";
import embed from "@editorjs/embed";
import image from "./image-override";
import list from "@editorjs/nested-list";
import quote from "@editorjs/quote";
import table from "@editorjs/table";
import textVariantTune from "@editorjs/text-variant-tune";
import underline from "@editorjs/underline";
import code from "@editorjs/code";

function configureTools(canUpload, csrf, imagesToDelete, attachesToDelete) {
    const tools = {
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
    };
    if(canUpload) {
        tools["image"] = {
            class: image,
            config: {
                imagesToDelete,
                endpoints: {
                    byFile: route('upload.store'),
                    byUrl: route('upload.store'),
                },
                additionalRequestHeaders: {
                    "X-CSRF-TOKEN": csrf,
                },
            },
        };
        tools["attaches"] = {
            class: attaches,
            config: {
                attachesToDelete,
                endpoint: route('upload.store'),
                additionalRequestHeaders: {
                    "X-CSRF-TOKEN": csrf,
                },
            },
        };
    }

    return tools;
}

export default ({ name, readOnly = false, canUpload = true, csrf, body = { blocks: [] }}) => ({
    init() {
        this.body = body;
        if(typeof body === 'object') {
            this.body = JSON.stringify(body);
        };
    },
    name,
    input: {
        ['x-model']: 'body',
        ['x-ref']: name,
        type: "hidden",
        name,
        // value: JSON.stringify(body),
    },
    editor: {
        'class': 'content is-medium editor',
        destroy() {
            this.editor.destroy();
        },
        ['x-ref']: `${name}-editor`,
        ['x-data']() {
            const that = this;
            return {
            init() {
            this.imagesToDelete = [];
            this.attachesToDelete = [];
            this.tools = configureTools(canUpload, csrf, this.imagesToDelete, this.attachesToDelete);
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
                    this.$dispatch(`editor-${event.type.toLowerCase()}-changed`, {
                        api,
                        event,
                        name,
                    })
                    const data = await api.saver.save();
                    that.body = JSON.stringify(data);
                    that.$dispatch('input', JSON.stringify(data));
                },
            })
        }}},
        [`x-on:editor-${name}-persisted`]() {
            if(canUpload) {
                Promise
                    .allSettled([
                        ...this.imagesToDelete.map(path => window.axios.delete(route('upload.destroy'), { data: { path } })),
                        ...this.attachesToDelete.map(path => window.axios.delete(route('upload.destroy'), { data: { path } })),
                    ])
                    .finally(() => {
                        this.imagesToDelete.length = 0;
                        this.attachesToDelete.length = 0;
                    })
            }
        }
    },
})
