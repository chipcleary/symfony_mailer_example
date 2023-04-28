# symfony_mailer_example

## About

A simple module that uses symfony mailer to send a custom email.

The module also provides a starterkit you can use to create your own custom
module.

CAVEAT: Symfony Mailer Example is provided by a novice developer who is just
learning how to use symfony_mailer. It's meant to offer a shortcut past some of
the hunting-and-pecking I went through when creating my first email. I hope it
saves you time but please do not consider it an authoritative resource.

Credits: This module was created with inspiration from
https://www.digitalnadeem.com/drupal/how-to-configure-symphony-mailer-in-drupal/
and relying on the documentation
https://www.drupal.org/docs/contributed-modules/drupal-symfony-mailer.

## Capabilities Included

The module programmatically sends a "hello world" email using:

- Twig variables to customize the content
- A mailer policy to provide the "templates" for the subject and body
- CSS, which may be overridden by the theme.

## How to Use

### Installation

1. Install symfony_mailer. See
   https://www.drupal.org/docs/contributed-modules/drupal-symfony-mailer/getting-started.
2. Send a test email to ensure it is configured appropriately. See
   SITE/admin/config/system/mailer/test.
3. Install symfony_mailer_example

### Sending a custom message

1. Go to SITE/send-hello-world. You'll see a simple form to send an email.
2. The field is for the `to` address. You may leave it blank, in which case it
   goes to your user email address, or fill it with an email address.
3. To send an email, click the button.

Note: You'll see this page is a modest customization of symfony mailer's
existing test email page.

### Modifying the message

1. Got to SITE/admin/config/system/mailer
2. Click on the row for `Symfony Mailer Example` > `Hello world email`
3. Edit the subject and or the template. The available twig variables are:
   - `lucky_number`
   - `to`
4. As you play with the example, tou can also, e.g., add a new email subtype in
   HelloWorldEmailBuilder.php, then create a new mailer policy for it including
   your own message. To send the new email from the test form, modify the call
   to `sendTypedEmail` in the `submitForm` function in
   `src/Form/HelloWorldForm.php`.

## How to Extend

If you want to create your own module, here are some common modifications you
may wish to make.

### Sending the email programmatically

Besides using the form to send your custom email, you will now also be able to
send it programmatically. Use this call:

```
$emailFactory = \Drupal::service('email_factory');
$emailFactory->sendTypedEmail('symfony_mailer_example', 'hello_world', RECIPIENT)
```

You'll need to provide the RECIPIENT.

### Modifying the message

1. Got to SITE/admin/config/system/mailer
2. Click on the row for `Symfony Mailer Example` > `Hello world email`
3. Edit the subject and or the template. The available twig variables are:
   - `lucky_number`
   - `to`

### Adding another message

1. Add a new email subtype in HelloWorldEmailBuilder.php
2. Create a new mailer policy for it including elements for the subject and
   body.

To send the new email, call
`sendTypedEmail('symphony_mailer_example, 'YOUR_SUBTYPE', RECIPIENT)`

### Deleting the form

If you do not want the form, delete:

- symfony_mailer_example.routing.yml.
- src/Plugin/Form/HelloWorldForm.php.

### Using custom variables

Twig variables can be used to individualize the contents of emails. They can be
used within mailer policies or, beyond the scope of this example, twig
templates.

To _create_ variables, edit the `build` function in
'HelloWorldEmailBuilder.php'.

To _use_ variables, edit the mailer policy. You can use twig syntax to include
variables in either the subject and/or the body.

### Providing custom css

CSS may be added to your theme. See
https://www.drupal.org/docs/contributed-modules/drupal-symfony-mailer/getting-started#s-css.

CSS may also be provided by your custom module.

- These classes may be overridden by your theme.
- The example provides a css file at css/mail.css. This css is added by the call
  to `addLibrary` in the `build` function in 'HelloWorldMailBuilder.php'.
- If you do not want the module to provide css, delete both 'css/mail.css' and
  symfony_mailer_example.libraries.yml. Then delete the call to `addLibrary` in
  the `build` function.

### Adding custom parameters

Caveat: I'm not clear about the potential and usage of parameters. The seem able
to capture any custom data you'd like to be available when building an email.
They seem to be used most commonly used to capture the recipient or sender.

To _provide_ additional parameters, edit the `createParams` function in
'HelloWorldEmailBuilder.php'. As you can see, this only provides one parameter
currently, `recipient`.

To _use_ parameters, edit the `build` function in 'HelloWorldEmailBuilder.php'.

There may well be other times when it's helpful to u se parameters. For more
examples, you search the base symfony_mailer module for "setParam".
