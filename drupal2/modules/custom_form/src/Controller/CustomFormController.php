<?php

namespace Drupal\custom_form\Controller;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Controller\ControllerBase;

require 'functions.php';

class CustomFormController extends FormBase {

  public function getFormId() {
    return 'custom_form';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {

    $query = \Drupal::database()->select('player_data', 'player');
    $query->fields('player', ['Nickname','ID']);
    $result = $query->execute();
    $list_option = array();

    while ($row = $result->fetchAssoc()) {
      $list_option[$row['Nickname']]=$row['Nickname'];
    }

    $form['Nickname'] = [
      '#type' => 'select',
      '#title' => $this->t('Nickname:'),
      '#placeholder' => 'Your nickname',
      '#attributes' => array('class' => array('champ')),
      '#prefix' => '<div class="test-label">',
      '#sufix' => '</div>',
      '#options' => $list_option,
    ];
    $form['Email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email:'),
      '#required' => TRUE,
      '#placeholder' => 'vespadev@vespadev.ro',
      '#attributes' => array('class' => array('champ')),
      '#prefix' => '<div class="test-label">',
      '#sufix' => '</div>',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Edit player'),
    ];

    return $form;
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $name=$form_state->getValue('Nickname');
    $email=$form_state->getValue('Email');

    $error = "For player ".$name;
    $error.= " you set this email: <strong>".$email."</strong>";
    \Drupal::database()->update('player_data')->condition('Nickname' , $name)->Fields(['Email' => $email])->execute();
    drupal_set_message($error);
  }

}
