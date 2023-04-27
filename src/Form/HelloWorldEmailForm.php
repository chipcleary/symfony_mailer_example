<?php

namespace Drupal\symfony_mailer_example\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\symfony_mailer\EmailFactoryInterface;
use Drupal\symfony_mailer\MailerHelperInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Symfony Mailer Example hello world email form.
 *
 * A form that provides an interface for sending the Hello World email.
 *
 * Based on the test email form in the symfony_mailer module.
 */
class HelloWorldEmailForm extends FormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'symfony_mailer_example_hello_world_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $form['#tree'] = true;

        $form['recipient'] = [
        '#title' => $this->t('Recipient'),
        '#type' => 'textfield',
        '#default_value' => '',
        '#description' => $this->t('Recipient email address. Leave blank to send to yourself.'),
        ];

        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Send'),
        '#button_type' => 'primary',
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {

        $emailFactory = \Drupal::service('email_factory');

        // If the "recipient" field is empty, send to the current user.
        $to = $form_state->getValue('recipient') ?: $this->currentUser();
        $emailFactory->sendTypedEmail('symfony_mailer_example', 'hello_world', $to);
        $message = is_object($to) ?
            $this->t('An attempt has been made to send an email to you.') :
            $this->t('An attempt has been made to send an email to @to.', ['@to' => $to]);
        $this->messenger()->addMessage($message);
    }

}
