/* This file is generated by Ziggy. */
declare module 'ziggy-js' {
  interface RouteList {
    "debugbar.openhandler": [],
    "debugbar.clockwork": [
        {
            "name": "id",
            "required": true
        }
    ],
    "debugbar.assets.css": [],
    "debugbar.assets.js": [],
    "debugbar.cache.delete": [
        {
            "name": "key",
            "required": true
        },
        {
            "name": "tags",
            "required": false
        }
    ],
    "debugbar.queries.explain": [],
    "dusk.login": [
        {
            "name": "userId",
            "required": true
        },
        {
            "name": "guard",
            "required": false
        }
    ],
    "dusk.logout": [
        {
            "name": "guard",
            "required": false
        }
    ],
    "dusk.user": [
        {
            "name": "guard",
            "required": false
        }
    ],
    "sanctum.csrf-cookie": [],
    "livewire.update": [],
    "livewire.upload-file": [],
    "livewire.preview-file": [
        {
            "name": "filename",
            "required": true
        }
    ],
    "ignition.healthCheck": [],
    "ignition.executeSolution": [],
    "ignition.updateConfig": [],
    "api.users.posts.store": [
        {
            "name": "user",
            "required": true
        }
    ],
    "api.users.posts.update": [
        {
            "name": "user",
            "required": true
        },
        {
            "name": "post",
            "required": true
        }
    ],
    "api.users.collections.index": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "api.users.collections.store": [
        {
            "name": "user",
            "required": true
        }
    ],
    "api.users.collections.update": [
        {
            "name": "user",
            "required": true
        },
        {
            "name": "collection",
            "required": true
        }
    ],
    "api.like": [],
    "api.posts.collections.store": [
        {
            "name": "content",
            "required": true,
            "binding": "id"
        }
    ],
    "api.collections.collections.store": [
        {
            "name": "content",
            "required": true,
            "binding": "id"
        }
    ],
    "api.upload.store": [],
    "api.upload.destroy": [],
    "index": [],
    "about": [],
    "contact": [],
    "register": [],
    "login": [],
    "login.show": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "logout": [],
    "user.feed": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "search": [],
    "users.posts.publish": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        },
        {
            "name": "post",
            "required": false,
            "binding": "id"
        }
    ],
    "users.posts.status": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        },
        {
            "name": "post",
            "required": true,
            "binding": "id"
        }
    ],
    "users.posts.index": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "users.posts.create": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "users.posts.store": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "users.posts.show": [
        {
            "name": "user",
            "required": true
        },
        {
            "name": "post",
            "required": true
        }
    ],
    "users.posts.edit": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        },
        {
            "name": "post",
            "required": true,
            "binding": "id"
        }
    ],
    "users.posts.update": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        },
        {
            "name": "post",
            "required": true,
            "binding": "id"
        }
    ],
    "users.posts.destroy": [
        {
            "name": "user",
            "required": true
        },
        {
            "name": "post",
            "required": true
        }
    ],
    "posts.show": [
        {
            "name": "post",
            "required": true,
            "binding": "id"
        }
    ],
    "posts.comments.index": [
        {
            "name": "post",
            "required": true,
            "binding": "id"
        }
    ],
    "posts.comments.store": [
        {
            "name": "post",
            "required": true,
            "binding": "id"
        }
    ],
    "posts.comments.show": [
        {
            "name": "post",
            "required": true
        },
        {
            "name": "comment",
            "required": true
        }
    ],
    "posts.comments.update": [
        {
            "name": "post",
            "required": true
        },
        {
            "name": "comment",
            "required": true
        }
    ],
    "posts.comments.destroy": [
        {
            "name": "post",
            "required": true
        },
        {
            "name": "comment",
            "required": true
        }
    ],
    "users.collections.publish": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        },
        {
            "name": "collection",
            "required": false,
            "binding": "id"
        }
    ],
    "users.collections.status": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        },
        {
            "name": "collection",
            "required": true,
            "binding": "id"
        }
    ],
    "users.collections.index": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "users.collections.create": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "users.collections.store": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "users.collections.show": [
        {
            "name": "user",
            "required": true
        },
        {
            "name": "collection",
            "required": true
        }
    ],
    "users.collections.edit": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        },
        {
            "name": "collection",
            "required": true,
            "binding": "id"
        }
    ],
    "users.collections.update": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        },
        {
            "name": "collection",
            "required": true,
            "binding": "id"
        }
    ],
    "users.collections.destroy": [
        {
            "name": "user",
            "required": true
        },
        {
            "name": "collection",
            "required": true
        }
    ],
    "collections.show": [
        {
            "name": "collection",
            "required": true,
            "binding": "id"
        }
    ],
    "users.collections.entries.destroy": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        },
        {
            "name": "collection",
            "required": true,
            "binding": "id"
        },
        {
            "name": "entry",
            "required": true,
            "binding": "id"
        }
    ],
    "collections.comments.index": [
        {
            "name": "collection",
            "required": true,
            "binding": "id"
        }
    ],
    "collections.comments.store": [
        {
            "name": "collection",
            "required": true,
            "binding": "id"
        }
    ],
    "collections.comments.show": [
        {
            "name": "collection",
            "required": true
        },
        {
            "name": "comment",
            "required": true
        }
    ],
    "collections.comments.update": [
        {
            "name": "collection",
            "required": true
        },
        {
            "name": "comment",
            "required": true
        }
    ],
    "collections.comments.destroy": [
        {
            "name": "collection",
            "required": true
        },
        {
            "name": "comment",
            "required": true
        }
    ],
    "events.ical": [],
    "events.index": [],
    "events.show": [
        {
            "name": "event",
            "required": true,
            "binding": "id"
        }
    ],
    "users.events.index": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "users.events.create": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "users.events.store": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "users.events.edit": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        },
        {
            "name": "event",
            "required": true,
            "binding": "id"
        }
    ],
    "users.events.update": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        },
        {
            "name": "event",
            "required": true,
            "binding": "id"
        }
    ],
    "users.events.destroy": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        },
        {
            "name": "event",
            "required": true,
            "binding": "id"
        }
    ],
    "events.attendees.store": [
        {
            "name": "event",
            "required": true,
            "binding": "id"
        }
    ],
    "events.attendees.destroy": [
        {
            "name": "event",
            "required": true,
            "binding": "id"
        },
        {
            "name": "attendee",
            "required": true,
            "binding": "id"
        }
    ],
    "users.profile.show": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "users.profile.edit": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "users.profile.update": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "users.followers.index": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "users.followers.store": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "users.followers.destroy": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        },
        {
            "name": "follower",
            "required": true,
            "binding": "id"
        }
    ],
    "users.following": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ]
}
}
export {};
