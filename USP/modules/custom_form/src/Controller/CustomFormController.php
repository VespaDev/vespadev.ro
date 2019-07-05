<?php

namespace Drupal\custom_form\Controller;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Controller\ControllerBase;
class CustomFormController extends FormBase {

  public function getFormId() {
    return 'custom_form';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {
    $query = \Drupal::database()->select('player_data', 'player');
    $query->fields('player', ['Nickname']);
    $result = $query->execute();$i=0;
    while ($row = $result->fetchAssoc()) {
	    $user[$i]= $row['Nickname'];$i++;
    }
    $form['Nickname'] = [
      '#type' => 'select',
      '#title' => $this->t('Nickname'),
      '#options' =>['1'=>$this->t($user[$i-1])],
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
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Edit player'),
    ];

    return $form;
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $name=$form_state->getValue('Nickname');
    $email=$form_state->getValue('Email');
    $pass=$form_state->getValue('Password');

    $error = "Your player name ".$name;
    $error.= " your email is ".$email;
    $error_exist=check_exist($name, $email);

    if($pass==$repass and $error_exist!=1){
      $pass=password_hash($pass, PASSWORD_DEFAULT);
      $error.= " and your password match with re-password";
      \Drupal::database()->insert('player_data')->fields(['Nickname','Email','Password',])->values(array($name,$email,$pass,))->execute();
      \Drupal::database()->update('player_data')->condition('employee_id' , 'CE 003')->updateFields(['employee_name' => 'Swathy','employee_age' => 20,])->execute();
      drupal_set_message($error);
    }
    else{
      $error.=" !!Your email already exist!! ";
      $error.= " and your password doesn't match with re-password";
      drupal_set_message($error, 'error');
    }
  }

}
