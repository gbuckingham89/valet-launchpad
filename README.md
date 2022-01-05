# 🚀 Valet Launchpad

[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/gbuckingham89/valet-launchpad/Tests/release?label=tests)](https://github.com/gbuckingham89/valet-launchpad/actions?query=workflow%3Atests+branch%3Arelease)

A web based UI for browsing the projects being served by [Laravel Valet](https://laravel.com/docs/valet).

![valet-launchpad](https://user-images.githubusercontent.com/1455253/147604731-d0c2b6a8-01dd-4386-a17a-8af90158eff6.gif)

Built on Laravel (with TailwindCSS & Alpine.JS), this small web app will show all the projects being served by Laravel Valet, give you quick access to all the URLs it's served via (linked or parked) and will highlight if there is a match / mismatch with your current PHP version. It works great when configured as your default project in Laravel Valet (see below for instructions). It comes complete with a light and dark UI, matching your OS preference.

## ℹ️ Requirements

- You must be using [Laravel Valet](https://laravel.com/docs/valet) to serve projects in your local environment
- Although Laravel Valet supports earlier versions, this application requires PHP >= 7.4
- The user that PHP-FPM is running under must have access to the Laravel Valet binary ([need help?](#valet-not-installed)) _(we hope to remove this requirement in the future)_

## 💾 Installation

_Ensure the above requirements are met before installing. These installation instructions assume you have some familiarity with running commands in your local terminal, Laravel and Laravel Valet._

Clone the `release` branch of this repository into a directory:

```shell
git clone https://github.com/gbuckingham89/valet-launchpad.git --branch release --single-branch
```

From the newly created directory in your Terminal, install the dependencies:

```shell
composer install --no-dev
```

Create a `.env` file:

```shell
cp .env.example .env
```

Generate an application key:

```shell
php artisan key:generate
```

Ensure the directory is being [served by Laravel Valet](https://laravel.com/docs/valet#serving-sites). If it's not already in a [parked directory](https://laravel.com/docs/valet#the-park-command), you can run:

```shell
valet link
```

Finally, using your preferred editor, open the `.env` file and set the value of the `APP_URL` option as appropriate (e.g. `APP_URL=http://valet-launchpad.test`). _You could also take this opportunity to customise the application name if you wish by editing the `APP_NAME` option._

**You should now be able to visit that URL in your preferred web browser.**

### Set as default Valet site

Laravel Valet can be configured to [serve a default site](https://laravel.com/docs/valet#serving-a-default-site) instead of a 404 error if you visit an unknown `.test` domain - that's a great use for this project!

Open your Laravel Valet config file (`~/.config/valet/config.json`) in your preferred editor.

If it doesn't already exist, add a `default` key, and ensure the value is set to the path of your `gbuckingham89/valet-launchpad` files. For example:

```json
{
    "default": "/Users/JoeBloggs/Sites/valet-launchpad"
}
```

## ⚠️ Troubleshooting

### Valet not installed

If you see errors about Valet not being installed (but you're sure that it is, and you see output by running `which valet` from your local terminal) it's likely that the user running PHP-FPM doesn't know where the Valet binary is located, or doesn't have permission to run it.

There are two ways to resolve this;

1. Find the value of the PATH environment variable for your shell by running `echo $PATH` from your local Terminal. Add the output of this to the `VALET_ASSISTANT_ENV_PATH` key in your `.env` file. This PATH value will then be used whenever the underlying [gbuckingham89/valet-assistant](https://github.com/gbuckingham89/valet-assistant) package executes a shell command. It is NOT used by code outside that package.
2. Add `/Users/[local-username]/.composer/vendor/bin` to the PATH environment for the user running the PHP script _(remember to insert the username that Valet is installed under)_

_**Please do your own research and consider any security implications of giving PHP access to additional directories through the PATH environment variable.**_

## 🏗 Updating

_Before updating, please take a backup of your current installation to prevent any potential data loss._

**Before starting, please review the [CHANGELOG](CHANGELOG.md) for any release specific instructions. If you're updating between multiple releases, please review the notes for each release.**

To update your installation, perform a GIT pull from the `release` branch:

```shell
git pull origin release
```

You should then also update the dependencies:

```shell
composer install --no-dev
```

To avoid any potential issues, you should also clear your caches:

```shell
php artisan config:clear && php artisan view:clear
```

## 🏷 Release process

This project follows Semver [2.0.0](https://semver.org/spec/v2.0.0.html) and each new release will be tagged appropriately.

The `master` branch is the development version. The latest release can be found on the `release` branch.

There is currently no defined release schedule. Watch this project in GitHub to receive notifications of future releases.

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed in each release, and any particular update instructions that need to be followed.

## 👨‍💻 Contributing

Contributions are not only welcomed, but encouraged. Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details - but if you're unsure of anything, just ask!

## 🔐 Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## 👪 Credits

- [George Buckingham](https://github.com/gbuckingham89)
- [All Contributors](../../contributors)

## ⚖️ License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
