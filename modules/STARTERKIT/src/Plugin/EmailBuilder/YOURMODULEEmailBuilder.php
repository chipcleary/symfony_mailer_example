<?php

namespace Drupal\YOUR_MODULE\Plugin\EmailBuilder;

use Drupal\symfony_mailer\EmailInterface;
use Drupal\symfony_mailer\Processor\EmailBuilderBase;
use Drupal\symfony_mailer\Processor\TokenProcessorTrait;

/**
 * Defines the Email Builder plug-in for the hello world mail.
 *
 * @EmailBuilder(
 *   id = "YOUR_MODULE",
 *   sub_types = { "YOUR_SUBTYPE" = @Translation("My custom email") },
 *   common_adjusters = {"email_subject", "email_body"},
 * )
 */
class YOURMODULEEmailBuilder extends EmailBuilderBase
{

    use TokenProcessorTrait;

    /**
     * Saves the parameters for a newly created email.
     *
     * @param \Drupal\symfony_mailer\EmailInterface $email
     *   The email to modify.
     *
     * @param mixed                                 $recipient
     *   The to address(es), see Address::convert().
     */
    public function createParams(EmailInterface $email, $recipient = null)
    {
        // You must provide a recipient when using this email
        assert($recipient != null);
        // Set the parameter to go to the receipent
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
            // See YOUR_MODULE.libraries.yml
            ->addLibrary('YOUR_MODULE/email');

            // No twig variables are included in the starterkit.
            // See Symfony Mailer Example for how to include them.
    }

}
