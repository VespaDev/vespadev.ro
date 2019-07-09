<?php

namespace Drupal\vespa_help\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Controller\ControllerBase;


class VespaHelp extends FormBase
{
  public function getFormId() {
  return 'vespa_help';
}
  public function buildForm(array $form, FormStateInterface $form_state) {
        //
        $query = \Drupal::database()->select('questions', 'u');
        $query->fields('u', ['ID','Nume','Descriere']);
        $results = $query->execute()->fetchAll();
        $output = array();
        foreach ($results as $result) {
           $output[$result->ID] = [
             'ID' => $result->ID,     // 'userid' was the key used in the header
             'Nume' => $result->Nume, // 'Username' was the key used in the header
             'Quest' => $result->Descriere,    // 'email' was the key used in the header
           ];
         }
        //
        $form['#prefix'] = '<div class="vespa_asks"><div class="sub-asks">';
        $form['#suffix'] = '</div></div>';
        $form['Title_msg'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Title_msg'),
          '#required' => TRUE,
          '#attributes' => array('class' => array('champ')),
        ];
        $form['Description'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Description'),
          '#required' => TRUE,
          '#placeholder' => 'Your nickname',
          '#attributes' => array('class' => array('champ')),
        ];

        $form['actions'] = [
          '#type' => 'submit',
          '#value' => $this->t('Add Quest'),
        ];
        $header = [
             'ID' => t('User id'),
             'Nume' => t('username'),
             'Quest' => t('Email'),
           ];

           $form['table'] = [
             '#type' => 'tableselect',
             '#header' => $header,
             '#options' => $output,
             '#empty' => t('No users found'),
           ];
        return $form;
      }

  public function submitForm(array &$form, FormStateInterface $form_state) {
      $name=$form_state->getValue('Title_msg');
      $desc=$form_state->getValue('Description');
      \Drupal::database()->insert('questions')->fields(['Nume','Descriere'])->values(array($name,$desc))->execute();
      drupal_set_message("New Questestion has been added");
    }


    //Furat

}


?>
