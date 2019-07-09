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

        $table = "<table>
                  <tr><td>Nume</td><td>Descriere</td></tr>
                  <tr><td>Info</td><td>Details</td></tr>
                </table>";

        $form['table'] = array(
            '#title' => $table,
            '#type' => 'item'
        );
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
