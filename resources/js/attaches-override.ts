// @ts-ignore
import AttachesTool from "@editorjs/attaches";

export default class AttachesOverride extends AttachesTool {
    attachesToDelete: string[];
    // @ts-ignore
    constructor({ data, api, config, readOnly }) {
        super({ data, api, config, readOnly });
        this.attachesToDelete = config.attachesToDelete || [];
    }

    removed() {
        // @ts-ignore
        const data = this._data.file.url;

        this.attachesToDelete.push(data);
    }
}
