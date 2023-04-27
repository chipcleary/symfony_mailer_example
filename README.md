# symfony_mailer_example

## About

A simple module that uses symfony mailer to send a custom email.

The module also provides a starterkit you can use to create your own custom module.

## Capabilities Included

The module programmatically sends a "hello world" email using:
- Twig variables to customize the content
- A mailer policy to provide the "templates" for the subject and body
- CSS, which may be overridden by the theme.

## How to Use

# Installation

1. Install symfony_mailer. See https://www.drupal.org/docs/contributed-modules/drupal-symfony-mailer/getting-started.
1. Send a test email to ensure it is configured appropriately. See SITE/admin/config/system/mailer/test.
1. Install symfony_mailer_example

# Sending a custom message

1. Go to SITE/send-hello-world. You'll see a simple form to send an email. 
2. The field is for the ```to``` address. You may leave it blank, in which case it goes to your user email address, or fill it with an email address. 
3. To send an email, click the button.

Note: You'll see this page is a modest customization of symfony mailer's existing test email page.

# Modifying the message

1. Got to SITE/admin/config/system/mailer
1. Click on the row for ```Symfony Mailer Example``` > ```Hello world email```
1. Edit the subject and or the template. The available twig variables are:
   - ```lucky_number```
   - ```to```
1. As you play with the example, tou can also, e.g., add a new email subtype in SymfonyMailerExampleEmailBuilder.php, then create a new mailer policy for it including your own message. To send the new email from the test form, modify the call to ```sendTypedEmail``` in the ```submitForm``` function in ```src/Form/HelloWorldForm.php```.

# How to Create Your Own Custom Module

## About this guidance

This is the sequence which I followed, with the additional support of the "STARTERKIT" module provided here. As you make this your own, you can consult the example module for a complete example.

The starterkit is a stripped down version of the example, which you can then build back up as befits your needs.

Note: While I hope this is useful, I'm not sure that it's best practice. 

## Installing the starterkit

1. Copy the symfony_mailer_example/modules/STARTERKIT folder to where you'd like your custom module to be.
1. Review what's there:
  - YOUR_MODULE.info.yml: same as always. You may want to change the package.
  - YOUR_MODULE.routing.yml: Defines the path for testing your custom email. You may want to delete this file when done.
  - YOUR_MODULE.libraries.yml: Declares CSS. You may want to declare css here or you can declare it in your theme.
  - src/Plugin/EmailBuilder/YOURMODULEEmailBuilder.php: 
     - This is where the email ```type``` and ```sub-type``` are declared. These are used later when creating a mailer policy.
     - To keep things simple, the starterkit uses hardcoded addresses. It sends an email from the site email address to the current user's email address.
     - To keep things simple, the starterkit does not provide twig variables to customize the email content. 
  - config/install/symfony_mailer.mailer_policy.YOUR_MODULE.YOUR_SUBTYPE.: Provides the mailer policy which declares the content of the mail. It can be edited via GUI at SITE/admin/config/system/mailer.
  - src/Plugin/Form/YOURMODULEForm.php: The form used to test your custom email. You may want to delete it when done (along with YOUR_MODULE.routing.yml).
  - css/mail.css: The css provided by the module. Note: This starts empty.
1. Select a name for your custom module (e.g., "YOUR_MODULE") and replace all instances of "STARTERKIT" with it. Both in filenames and in file contents.
   - Note: You'll see that some filenames and definitions use CamelCase instead of underscores
   - If doing global search-and-replace, do two replacements:
     - ```StarterKitModule``` -> ```YourModule```
     - ```starterkit_module``` -> ```your_module```
1. Select a name for the custom email you will create. Replace all instances of ```your_module_subtype``` with it. (Note: This will have started as ```starterkit_subtype``` in the original files but will have been changed in the prior step.

## Testing the starterkit

1. Now that you've customized the starterkit, install it.
1. Go to <site>/YOUR_MODULE/test to see the test form
1. Click on the button to send an email from the site to yourself.

Note: After you install, a default mailer policy will be available which you can edit. 

## Send email programmatically
  
Besides using the form to send your custom email, you will now also be able to send it programmatically. Use this call: 
   
   '''
    $emailFactory = \Drupal::service('email_factory');
    $emailFactory->sendTypedEmail(YOUR_MODULE, YOUR_SUBTYPE, TO)
    '''

Replace YOUR_MODULE, YOUR_SUBTYPE, and TO when using it.

## Extending the starterkit

### Extend the form

1. To change the path, edit YOUR_MODULE.routing.yml.
1. To extend the form, edit src/Plugin/Form/YOURMODULEForm.php.

You can use the example module code as a starting point.

### Set custom parameters

Caveat: I'm not clear about the full potential of parameters. The seem able to capture any custom data you'd like to be available when building an email. They seem to be used most commonly used to capture the recipient or sender.

To *create* parameters, edit the ```createParams``` function in 'YOURMODULEEmailBuilder.php'. 

To *use* parameters, edit the ```build``` function in 'YOURMODULEEmailBuilder.php'.

There may well be other times when it's helpful to u se parameters. For more examples, you search the base symfony_mailer module for "setParam".

### Set custom variables

Twig variables are used to customize the contents of emails. They can be used within mailer policies or, beyond the scope of this example, twig templates.

To *create* variables, edit the ```build``` function in 'YOURMODULEEmailBuilder.php'.

To *use* variables, edit the mailer policy. You can use twig syntax to include variables in either the subject and/or the body.

### Set custom css

CSS may be added to your theme. See https://www.drupal.org/docs/contributed-modules/drupal-symfony-mailer/getting-started#s-css.

CSS may also be provided by your custom module. These classes may be overridden by your theme.

The starterkit provides a blank css file at css/mail.css. This css is added to your custom emails by the call to 'addLibrary' in the 'build' function in 'YOURMODULEEMailBuilder.php'.

If you want css added by the module, go ahead and add it to 'css/mail.css'. If not, delete both 'css/mail.css' and the call to 'addLibrary' in the 'build' function.



