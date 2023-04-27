# symfony_mailer_example

## About

A simple custom module that uses symfony mailer to send a cutom email.

The module also provides a starterkit you can use to create your own custom module.

## Capabilities Included

The module programmatically sends a "hello world" email using:
- A couple of twig variables used to customize the content
- A mailer policy that provides the "templates" for the subject and body
- CSS provided by the module, which may be overridden by the theme.

## How to Use

# Installation

1. Install symfony_mailer. See https://www.drupal.org/docs/contributed-modules/drupal-symfony-mailer/getting-started.
1. Send a test email to ensure it is configured appropriately. See http://team-lead-challenges.local/admin/config/system/mailer/test.
1. Install symfony_mailer_example

# Sending a custom message

Go to <site>/send-hello-world. You'll see a simple form to send an email. Either leave the field blank or fill it with an email address and click the button.

Note: You'll see this page is a modest customization of symfony mailer's existing test email page.

# Modifying the message

1. Got to <site>/admin/config/system/mailer
1. Click on the row for "Symfony Mailer Example" / "Hello world email"
1. Edit the subject and or the template. The available twig variables are:
   - lucky_number
   - to
1. If you make changes you want to save, export the configuration (<site>/admin/config/development/configuration/single/export) and update the configuration file in the example module. It is listed as a "Mailer Policy" named as above.
1. You can also, e.g., add a new email subtype in SymfonyMailerExampleEmailBuilder.php, then create a new mailer policy for it including your own message. To use it, modify the call to 'sendTypedEmail' in 'submitForm' in 'src/Form/HelloWorldForm.php'.

# How to Create Your Own Custom Module

## About this guidance

This is the sequence which I followed, scaffolded by a "STARTERKIT" module. As you go, you can consult the example module.

The starterkit is a stripped down version of the example, which you can then build back up as befits your needs.

Note: While I hope this is useful, I'm not sure that it's best practice. 

## Installing the starterkit

1. Copy symfony_mailer_example/modules/STARTERKIT to where you'd like your custom module to be.
1. Select a name for your custom module (e.g., "YOUR_MODULE") and replace all instances of "STARTERKIT" with it. Both in filenames and in the file contents.
1. Select a name for the custom email you will create (e.g., "YOUR_SUBTYPE"). Replace all instances of "YOUR_MODULE_SUBTYPE" with it.
1. Review what's there:
  - YOUR_MODULE.info.yml: same as always. You may want to change the package.
  - YOUR_MODULE.routing.yml: This creates a path you can use to test your custom email. You likely want to delete it when done.
  - YOUR_MODULE.libraries.yml: This declares the css file provided by the module. You may want to declare css here or you can declare it in your theme.
  - src/Plugin/EmailBuilder/YOURMODULEEmailBuilder.php: 
     - This is where the email "type" and "sub-type" are declared. These are used later when creating a mailer policy.
     - To keep things simple, the starterkit sends an email from the site email address to the current user's email address. You can customize this later.
     - To keep things simple, the starterkit does not use twig variables to customize the email content. You can add these later.
  - config/install/symfony_mailer.mailer_policy.YOUR_MODULE.YOUR_SUBTYPE.: This provides the content of the mail and is edited at <site>/admin/config/system/mailer.
  - src/Plugin/Form/YOURMODULEForm.php: The form used to test your custom email. You likely want to delete it when done (along with YOUR_MODULE.routing.yml).
  - css/mail.css: The css provided by the module. Note: This starts empty.

## Testing the starterkit

1. Now that you've customized the starterkit, install it.
1. Go to <site>/YOUR_MODULE/test to see the test form
1. Click on the button to send an email from the site to yourself.

Note: Until you install, your custom email type and subtype will not be available, so you cannot add a mailer policy to declare their content. After you install, a default mailer policy will be available which you can edit.

You will now also be able to send your custom email using this call: 
   
   '''
    $emailFactory = \Drupal::service('email_factory');
    $emailFactory->sendTypedEmail(YOUR_MODULE, YOUR_SUBTYPE, TO)
    '''

Replace YOUR_MODULE, YOUR_SUBTYPE, and TO when using it.

## Extending the starterkit

### Extend the form

1. You may want to change the path to the page. If so, edit YOUR_MODULE.routing.yml.
1. You may want to extend the form. If so, edit src/Plugin/Form/YOURMODULEForm.php.

You can use the example module code as a starting point.

### Set custom parameters

I'll to not being clear about the full potential of parameters. The seem able to capture any desired custom data for use when building an email. They seem to be used most commonly used to capture the recipient or sender.

To *create* parameters, edit the 'createParams' function in 'YOURMODULEEmailBuilder.php'. 

One way to use parameters is when building the email. To see an example, edit the 'build' function in 'YOURMODULEEmailBuilder.php'.

For more examples, you can search within the base symfony_mailer module for "setParam".

### Set custom variables

Variables are used to customize the contents of emails. They can be used within mailer policies or, beyond the scope of this example, twig templates.

To *create* variables, edit te 'build' function in 'YOURMODULEEmailBuilder.php'.

To *use* variables, edit the mailer policy. You can use twig syntax to include variables in either the subject and/or the body.

### Set custom css

CSS may be added to your theme. See XXX.

CSS may also be provided by your custom module. These classes may be overridden by your theme.

The starterkit provides a blank css file at css/mail.css. This css is added to your custom emails by the call to 'addLibrary' in the 'build' function in 'YOURMODULEEMailBuilder.php'.

If you want css added by the module, go ahead an add it to 'css/mail.css'. If not, delete both 'css/mail.css' and the call to 'addLibrary' in the 'build' function.



