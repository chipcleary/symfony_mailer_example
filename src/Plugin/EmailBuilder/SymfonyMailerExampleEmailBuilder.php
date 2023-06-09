<?php

namespace Drupal\symfony_mailer_example\Plugin\EmailBuilder;

use Drupal\symfony_mailer\EmailInterface;
use Drupal\symfony_mailer\Processor\EmailBuilderBase;
use Drupal\symfony_mailer\Processor\TokenProcessorTrait;

/**
 * Defines the Email Builder plug-in for the hello world mail.
 *
 * @EmailBuilder(
 *   id = "symfony_mailer_example",
 *   sub_types = { "hello_world" = @Translation("'Hello World!' email") },
 *   common_adjusters = {"email_subject", "email_body"},
 * )
 */
class SymfonyMailerExampleEmailBuilder extends EmailBuilderBase
{

    use TokenProcessorTrait;

    /**
     * Saves the parameters for a newly created email.
     *
     * @param \Drupal\symfony_mailer\EmailInterface $email
     *   The email to modify.
     * @param mixed                                 $recipient
     *   The to addresses, see Address::convert().
     */
    public function createParams(EmailInterface $email, $recipient = null)
    {
        // We require a recipient
        assert($recipient != null);
        $email->setParam('recipient', $recipient);
    }

    /**
     * {@inheritdoc}
     */
    public function build(EmailInterface $email)
    {
        if ($recipient = $email->getParam('recipient')) {
            $email->setTo($recipient);
        }

        $email
            // Add the CSS library.
            // See symfony_mailer_example.libraries.yml
            ->addLibrary('symfony_mailer_example/email')
            // Add twig variables
            // See symfony_mailer.mailer_policy.symfony_mailer_example.hello_world.yml
            ->setVariable('lucky_number', random_int(1, 100))
            ->setVariable('test_var', 'Your lucky day!');
    }

}
