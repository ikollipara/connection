# ConneCTION

ConneCTION is an online Professional Learning Community targeted at Computer Science Teachers around the country.
The application is a Laravel Monolith built with BulmaCSS, Alpine.js, Turbolinks, and Livewire for the Frontend.

The application is open-sourced for any members curious about how the actual application works.

## Contributing

To work on the project you need Docker installed.
To create a development environment, run the following commands:

```bash
bin/setup-container.sh
```

Or if you are using Windows:

```powershell
.\bin\setup-container.ps1s
```

This will create a container with all the necessary dependencies installed.

To start the development server, run the following command:

```bash
./vendor/bin/sail up
```

Or if you are using Windows:

```powershell
.\vendor\bin\sail up
```
