<?php

namespace Drupal\delete_player\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Controller\ControllerBase;

class DeleteP extends FormBase {

  public function getFormId() {
    return 'delete_player';
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
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Edit player'),
    ];

    return $form;
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $name=$form_state->getValue('Nickname');

    //$queryx = \Drupal::database()->delete('player_data')->condition('player', ['Nickname', $name])->execute();
    $query = \Drupal::database()->delete('player_data');
    $query->condition('Nickname' , $name);
    $result = $query->execute();

    $error = $name." has been deleted succesfully!";
    drupal_set_message($error);
  }

}
