<?php

namespace Drupal\drupalup_simple_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Controller\ControllerBase;
require 'functions.php';
class SimpleForm extends FormBase {

  public function getFormId() {
    return 'drupalup_simple_form';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['Nickname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Nickname'),
      '#required' => TRUE,
      '#placeholder' => 'Your nickname',
    ];

    $form['Email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
      '#placeholder' => 'vespadev@vespadev.ro',
    ];
    $form['Password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
      '#required' => TRUE,
    ];
    $form['RePass'] = [
      '#type' => 'password',
      '#title' => $this->t('Re-pass'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Create player'),
    ];

    return $form;
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $name=$form_state->getValue('Nickname');
    $email=$form_state->getValue('Email');
    $pass=$form_state->getValue('Password');
    $repass=$form_state->getValue('RePass');

    $error = "Your player name ".$name;
    $error.= " your email is ".$email;
    $error_exist=check_exist($name, $email);

    if($pass==$repass and $error_exist!=1){
      $pass=password_hash($pass, PASSWORD_DEFAULT);
      $error.= " and your password match with re-password";
      \Drupal::database()->insert('player_data')->fields(['Nickname','Email','Password',])->values(array($name,$email,$pass,))->execute();
      drupal_set_message($error);
    }
    else{
      $error.=" !!Your email already exist!! ";
      $error.= " and your password doesn't match with re-password";
      drupal_set_message($error, 'error');
    }
  }

}
