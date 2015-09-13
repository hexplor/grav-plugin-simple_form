# Grav Simple Form Plugin

`Simple Form` is a [Grav](http://github.com/getgrav/grav) plugin and add the simple form for contact service by [Simple Form](https://getsimpleform.com/) in Grav pages with the power of ajax from jQuery (_required **javascript library**_).

# Installation

Installing the plugin can be done in one of two ways. Our GPM (_Grav Package Manager_) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

## GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's Terminal (_also called the **command line**_).  From the root of your Grav install type:

    bin/gpm install simple_form

This will install the Simple Form plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/simple_form`.

## Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `simple_form`. You can find these files either on [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/simple_form

>> NOTE: This plugin is a modular component for Grav which requires [Grav](http://github.com/getgrav/grav), the [Error](https://github.com/getgrav/grav-plugin-error) and [Problems](https://github.com/getgrav/grav-plugin-problems) plugins, and a theme to be installed in order to operate.

# Usage

First of all you need to go to [Simple Form](https://getsimpleform.com/) and get new API. Use your email to receive the API key directly to your email address. When you have API key you can use this into plugin configuration file. The plugin comes with some sensible default configuration, that are pretty self explanatory:

# Admin Plugin Options

You can use this plugin when you working on page, into the "Options" tab you can configure the plugin.

# Page Options

|      Variable     |         Description         | Default |           Example         |
| :---------------- | :-------------------------- | :------ | :------------------------ |
| `token`           | simpleform.com token        |         | `token: 1234567890abcdef` |
| `template_file`   | Template file name          | default | `template_file: default`  |
| `redirect_to`     | Route when the form sended  |         | `redirect_to: /thank-you` |

> **NOTE**: Template file need to stay into your template directory following this structure: `{theme-name}/templates/plugins/simple_form/{template_file}.html.twig`.

> **NOTE**: Template name displayed into the admin plugin page options tab is possible to translate, following this structure "PLUGIN_SIMPLE_FORM.TEMPLATES.{template_file|upper}. Example for the default template used this string: PLUGIN_SIMPLE_FORM.TEMPLATES.DEFAULT.

Options per-page example:

    ---
    title: 'My "Page"'

    simple_form:
        token: "xxxxx"
        template_file: default
        redirect_to: /thank-you-for-my-page
    ---

    # "Lorem ipsum dolor sit amet"

With version 1.3.0 you need to put into your template the Twig Function `{{ simple_form({ token: "xxx", template_file: "default", redirect_to: "/thank-you" }) }}`. If you want use the header params instead passing the params into the Twig Function you can use `{{ simple_form() }}` and the plugin check the page header information's.

You can customize the design of form override the files in `user/plugins/simple_form/templates/plugins/simple_form/` to `user/themes/your-theme/templates/plugins/simple_form/`.

From the version 1.1.0 we have added the configuration key `template_file` to override the default template file for the form and load `{template_file}.html.twig`. The scenario is for the multiple/modular pages, this is a simple example:

#### Contact Us
    ---
    title: "Contact Us"
    simple_form:
        token: "token-for-contact-us"
        template_file: "contact_us"
        redirect_to: /thank-you-for-contact-us

    process:
      twig: true
    ---
    {{ simple_form() }}

In this scenario the template file loaded is `plugins/simple_form/contact_us.html.twig`.

#### Share your idea
    ---
    title: "Share your idea with us"
    simple_form:
        token: "token-for-share-your-idea-with-us"
        template_file: "share_your_idea_with_us"
        redirect_to: /thank-you-for-share-your-idea-with-us
    process:
      twig: true
    ---
    ## Share your idea with us
    Please use this form to share your idea:

    {{ simple_form() }}

In this scenario we have another page or modular page with another token (_then another email format_) and use another template for the form view, the template file is `plugins/simple_form/share_your_idea_with_us.html.twig`.

we suggested to use page header to configure simple_form then create a dedicated template for contact page then you use a empty function for see the form:

    {{ simple_form() }}

> **NOTE:** With 0.9.11 Grav added a fix for modular templates with twig process for page, you need to add into your page header where you need to parsing twig function from page:
    process:
      twig: true

# Updating

As development for this plugin continues, new versions may become available that add additional features and functionality, improve compatibility with newer Grav releases, and generally provide a better user experience. Updating this plugin is easy, and can be done through Grav's GPM system, as well as manually.

## GPM Update (_Preferred_)

The simplest way to update this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm). You can do this with this by navigating to the root directory of your Grav install using your system's Terminal (_also called **command line**_) and typing the following:

    bin/gpm update simple_form

This command will check your Grav install to see if your plugin is due for an update. If a newer release is found, you will be asked whether or not you wish to update. To continue, type `y` and hit **enter**. The plugin will automatically update and clear Grav's cache.

## Manual Update

Manually updating this plugin is pretty simple. Here is what you will need to do to get this done:

* Delete the `your/site/user/plugins/simple_form` directory.
* Download the new version of this plugin from either [GetGrav.org](http://getgrav.org/downloads/plugins#extras).
* Unzip the zip file in `your/site/user/plugins` and rename the resulting folder to `simple_form`.
* Clear the Grav cache. The simplest way to do this is by going to the root Grav directory in terminal and typing `bin/grav clear-cache`.

> **Note:** Any changes you have made to any of the files listed under this directory will also be removed and replaced by the new set. Any files located elsewhere (_for example a YAML settings file placed in_ `user/config/plugins`) will remain intact.
