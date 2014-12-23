# Grav Simple Form Plugin

`Simple Form` is a [Grav](http://github.com/getgrav/grav) plugin and add the simple form for contact service by [https://getsimpleform.com/](Simple Form) in Grav pages with the power of ajax from jQuery (_required javascript library_).

# Installation

Installing the plugin can be done in one of two ways. Our GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

## GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's Terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install simple_form

This will install the Simple Form plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/simple_form`.

## Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `simple_form`. You can find these files either on [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/simple_form

>> NOTE: This plugin is a modular component for Grav which requires [Grav](http://github.com/getgrav/grav), the [Error](https://github.com/getgrav/grav-plugin-error) and [Problems](https://github.com/getgrav/grav-plugin-problems) plugins, and a theme to be installed in order to operate.

# Usage

First of all you need to go to [https://getsimpleform.com/](Simple Form) and get new API. Use your email to receive the API key directly to your email address. When you have API key you can use this into plugin configuration file. The plugin comes with some sensible default configuration, that are pretty self explanatory:

# Options

    enabled: (true|false)                       // Enables or Disables the entire plugin for all pages (default: true).

    token: (string)                             // Token get form http://getsimpleform.com website.

    auto_content: (bool)                        // Enable the auto replace of page content with the form (default: false).
    short_code: (bool)                          // Enable the parsing of page content to replace the short code with the form (short_code: {[simple_form]}) without replace all content (default: true).

    fields:                                     // All fields are dinamic, then you can add here some fields and displayed on the form. Remember to add this fields in your email model from [https://getsimpleform.com/](Simple Form).
      name:
        type: "text"
        title: "Name"
        default: ""
        placeholder: "Add your name"
        class: ""
        required: true

      email:
        type: "email"
        title: "Email"
        default: ""
        placeholder: "Add your email"
        class: ""
        required: true

      message:
        type: "textarea"
        title: "Message"
        default: ""
        placeholder: "Add your message"
        class: ""
        required: true

      submit:
        type: "submit"
        title: "Submit"
        default: ""
        #placeholder: ""
        class: ""
        #required: true

    messages:
      success: "Your message has been sent."    // Message text when the email are sended.

To customize the plugin, you first need to create an override config. To do so, create the folder `user/config/plugins` (if it doesn't exist already) and copy the [simplecontact.yaml](simplecontact.yaml) config file in there and then make your edits.

You can customize the design of form override the files in `user/plugins/simple_form/templates/plugins/simple_form/` to `user/themes/your-theme/templates/plugins/simple_form/`.

Also you can override the default options per-page:

    ---
    title: 'My "Page"'

    simple_form:
      token: "xxxxx"
    ---

    # "Lorem ipsum dolor sit amet"

Or if you want use a config options then you can easy use this method:

    ---
    title: 'My "Page"'

    simple_form: true
    ---

    # "Lorem ipsum dolor sit amet"

With this method you use the config file options instead you write the options in the page header.

# Updating

As development for this plugin continues, new versions may become available that add additional features and functionality, improve compatibility with newer Grav releases, and generally provide a better user experience. Updating this plugin is easy, and can be done through Grav's GPM system, as well as manually.

## GPM Update (Preferred)

The simplest way to update this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm). You can do this with this by navigating to the root directory of your Grav install using your system's Terminal (also called command line) and typing the following:

    bin/gpm update simple_form

This command will check your Grav install to see if your plugin is due for an update. If a newer release is found, you will be asked whether or not you wish to update. To continue, type `y` and hit enter. The plugin will automatically update and clear Grav's cache.

## Manual Update

Manually updating this plugin is pretty simple. Here is what you will need to do to get this done:

* Delete the `your/site/user/plugins/simple_form` directory.
* Downalod the new version of the Simple Form plugin from either [GetGrav.org](http://getgrav.org/downloads/plugins#extras).
* Unzip the zip file in `your/site/user/plugins` and rename the resulting folder to `simple_form`.
* Clear the Grav cache. The simplest way to do this is by going to the root Grav directory in terminal and typing `bin/grav clear-cache`.

> Note: Any changes you have made to any of the files listed under this directory will also be removed and replaced by the new set. Any files located elsewhere (for example a YAML settings file placed in `user/config/plugins`) will remain intact.
