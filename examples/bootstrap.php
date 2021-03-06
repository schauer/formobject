<?php

ini_set("display_errors","On");

error_reporting(E_ALL);

require_once "lib/AutoLoader.php";
require_once "lib/simple_init.php";

use FormObject\Form;
use FormObject\Field;
use FormObject\Field\TextField;
use FormObject\Field\Action;
use FormObject\Field\CheckboxField;
use FormObject\Field\BooleanRadioField;

use FormObject\Validator\SimpleValidator;
use FormObject\Validator\TextValidator;
use FormObject\Validator\BooleanValidator;
use FormObject\Validator\RequiredValidator;
use FormObject\Validator\ValidationException;



/**
 * @brief ...
 * @var \FormObject\Form
 */
$form = Form::create($factory);

$form->push(

    TextField::create('name')
               ->setTitle('Please enter your name')
               ->setValue('Billy'),

    TextField::create('surname')
               ->setTitle('Please enter your surname')
               ->setValue('Talent'),

    CheckboxField::create('rememberMe')
                   ->setTitle('Remember Me'),


    BooleanRadioField::create('rememberMyRadio')
                       ->setTitle('Remember my radio')
                       ->setStringForTrue('Remember my radio')
                       ->setStringForFalse('Forget my radio')
                       ->setValue(TRUE),

    TextField::create('message')
               ->setTitle('Message')
               ->setValue('')
               ->setMultiLine(TRUE)
);

$nameValidator = new TextValidator();
$nameValidator->required = FALSE;
$nameValidator->minLength = 3;
$nameValidator->setMaxLength = 12;

$surnameValidator = new RequiredValidator;
$surnameValidator->required = TRUE;

$requiredValidator = new BooleanValidator();
$requiredValidator->mustBeTrue = TRUE;

$validator = new SimpleValidator($form);
$validator->set('name', $nameValidator);
$validator->set('surname', $surnameValidator);
$validator->set('rememberMyRadio', $requiredValidator);
$validator->set('message', $requiredValidator);

$form->setValidator($validator);

$data = array();

try{
    $data = $form->getData();
}
catch(ValidationException $e){}

include dirname(__FILE__).'/themes/bootstrap/templates/index.phtml';