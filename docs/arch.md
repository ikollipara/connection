# Architecture

The application follows the standard Laravel MVC Framework.

## Controllers
For controllers, this means all meaningful business logic should be found on the model classes.
That is, the controllers should only ever import from the models, the `Illuminate\Http` namespace, and the `Illuminate\Facades` namespace, and the `App\Http` namespace.

Controllers should never define **public** custom methods.
The accepted methods for a controller are:
- `index`
- `create`
- `store`
- `show`
- `edit`
- `update`
- `delete`

Controllers should follow the naming convention of `<Model*>Controller` where `Model*` is the singular model name(s) StudlyCased.
All middleware should be defined on the controller's `middleware` method.

## Models
Models are the core of the application, and thus the home for all business logic.
All **public** methods should be 100\% tested. If this is not possible, then refactor.

All models should follow the following specification:
- The name should be a singular version of the table name. If an exception is needed, please document why.
- The model should only utilize traits coming from Laravel itself, 3rd party packages, & the `Models\Concerns` namespace.
- The model should define the attributes in the following order:
    - `$fillable`
    - `$attributes`
    - `$hidden`
    - `$casts`
    - `protected static booted()`
    - `relationships`
    - `Getters & Setters`
    - `Scopes`
    - `Alternative Class Contructors`
    - `Public Methods`
    - `Protected Methods`
    - `Private Methods`

Prefer `$fillable` over `$guarded` since the former is more explict.

The models should communicate with each other through 2 methods:
- Methods (Preferred)
- Events

That is, models should accept other models as method parameters and do actions that way, rather than having some verb class do the work.
In the case of events, if a model action should be known and creating a method is not practical, then an event may be used. However, all listeners must contain a `@see` in their docblock denoting where to find the model event emitter.

### Readonly Models
If a model is representing a database view, then the model should use `Models\Concerns\AsView` which marks the models as non-creatable or save-able.

## Views
The views for the application are written in Vue.js.
The views are found in `resources/js/` and are organized as follows:
- `resources/js/Pages`: All the full pages found for the application. Should follow the naming convention of `<Controller>/<Action>` with both parts StudlyCase.
- `resources/js/Components`: All generic components for the application. Before anything can be added, it must be repeated 3 times.
- `resources/js/Page/**/partials`: All view parts that are generic to the sub-directory. That is, Vue Components that are used only in that directory tree.

The styling of the frontend is with TailwindCSS & Flowbite. To enable rapid development make heavy use of the flowbite components.
Since we are developing our views in Vue, we make use of the `flowbite-vue` package to speed up development.
Before creating a custom component, check if there is already a component in `flowbite-vue` or in the library already.

## Enforcment

To enforce these rules, the new Pest Architecture tests will be used.
This includes the Vue View Files.

## References
- https://pestphp.com/docs/arch-testing
- https://vuejs.org/
- https://en.wikipedia.org/wiki/Rule_of_three_(computer_programming)
- https://flowbite.com
- https://tailwindcss.com
- https://flowbite-vue.com/pages/getting-started
