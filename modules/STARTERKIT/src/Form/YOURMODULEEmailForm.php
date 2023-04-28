<?php

namespace Drupal\YOUR_MODULE\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\symfony_mailer\EmailFactoryInterface;
use Drupal\symfony_mailer\MailerHelperInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form to test sending your custom email.
 *
 * This is the simplest example possible.
 */
class YOURMODULEEmailForm extends FormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'YOUR_MODULE_email_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $form['#tree'] = true;

        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Send Your Email'),
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
        $emailFactory->sendTypedEmail('YOUR_MODULE', 'YOUR_SUBTYPE', \Drupal::currentUser());

        $message = $this->t('An attempt has been made to send an email to you.');
        $this->messenger()->addMessage($message);
    }

}
