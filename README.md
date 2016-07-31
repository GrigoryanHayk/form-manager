Form Manager
===============
Form Manager for managing and building forms in Safan Framework.

REQUIREMENTS
------------
PHP > 5.4.0

INSTALLATION
------------
If you're using [Composer](http://getcomposer.org/) for your project's dependencies, add the following to your "composer.json":
```
"require": {
    "safan-form/form-manager": "1.*"
}
```

Update Modules Config List - safan-framework-standard/application/Settings/modules.config.php
```
<?php
return [
    // Safan Framework default modules route
    'Safan'         => 'vendor/safan-lab/safan/Safan',
    'SafanResponse' => 'vendor/safan-lab/safan/SafanResponse',
    // Write created or installed modules route here ... e.g. 'FirstModule' => 'application/Modules/FirstModule'
    'FormManager' => 'vendor/safan-form/form-manager/FormManager',
];
```

Add Configuration - safan-framework-standard/application/Settings/main.config.php
```
<?php
'init' => [
    'form' => [
        'class'  => 'FormManager\FormManager',
        'method' => 'init',
    ]
]
```

USAGES
------
The FormManager initialized in Safan Handler by name 'formManager' , to use this class , call e.g.
```
$formManager = Safan::handler()->getObjectManager()->get('formManager');
```

To declare the type of form , you can use...
```
$form = $formManager->generateForm(new YourCustomForm());
```

To use FormManager first you need to declare a Class in namespace 'Form' in your Module which wil extend FormType Class this is the class which contain form credentials.
FormType is default class which namespace is FormManager/Type/FormType.
e.g.

```
<?php

namespace Main\Modules\Main\Form;

use FormManager\Type\FormType;
use FormManager\Builder\FormBuilderInterface;

class ContactType extends FormType
{

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder->addAction('/')
                ->add('name', '', [
                                    'label' => 'Name',
                                    'attr' => ['class' => 'form-control', 'required' => 'required'],
                                    'validation' => ['min' => 5]
                                ]
                )
                ->add('email', 'email', [
                                            'label' => 'Email',
                                            'attr' => ['class' => 'form-control', 'required' => 'required'],
                                            'validation' => [
                                                'min' => 5,
                                                'message' => 'Incorrect email address.',
                                                'callback' => function($email) {
                                                    return preg_match("/^[a-z0-9_-]{1,20}@(([a-z0-9-]+\.)+(com|net|org|mil|"."edu|gov|arpa|info|biz|inc|name|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-"."9]{1,3}\.[0-9]{1,3})$/is", $email);
                                                }
                                            ],
                                        ]
                )
                ->add('body', 'textarea', [
                                            'label' => 'Body',
                                            'attr' => ['class' => 'contactTextarea form-control', 'style' => 'height:100px;resize: none;' ,'id' => 'myCustomIdForTextarea'],
                                            'validation' => ['min' => 5]
                                        ]
                )
                ->add('submit', 'submit', [
                                            'attr' => ['class' => 'btn btn-primary col-md-12 col-sm-12 col-xs-12', 'value' => "Send"]
                                        ]
                )
                ->addMethod('post')
                ->addEnctype('multipart/form-data');
    }

    public function getName()
    {
        return 'contact';
    }
}
```

Your FormType Class have to declare two abstract methods --- 'buildForm()' and 'getName()'.
first method  - 'buildForm()' has dependency of FormBuilder $builder which builds forms fields .
second method - 'getName()' returns the name of form which you can get in Form Class.

For any type of vield you can declare 'validation' which will be validated in initialization in FormValidation Class.
Now are supported 'min', 'max' and 'callback' validations , but you can add your custom types extending Vaidation Class and declaring your custom methods in that Class.

'callback' must return boolean type.
There ara default 'messages' for types 'min' and 'max', but you can declare custom messages adding 'message' type in 'validation' array.

VIEW
----
To build form in view you can use ... (e.g. in example we use bootstrap classes to build form in bootstrap view, but you can use your native classes or another framework for frontend view)

```
<div class="col-sm-6 mt15">
    <form action="<?= $form->action() ?>" method="<?= $form->method() ?>" enctype="<?= $form->enctype() ?>">
        <?= $form->formErrors(); ?>
        <div class="row">
            <div class="col-sm-12 mb20">
                <div class="form-group">
                    <?= $form->row($form->name()); ?>
                </div>
                <div class="form-group">
                    <?= $form->row($form->email()); ?>
                </div>
                <div class="form-group">
                    <?= $form->row($form->body()); ?>
                </div>

                <div class="form-group">
                    <?= $form->row($form->submit()); ?>
                </div>
            </div>
        </div>
    </form>1
</div>
```

Every field is declared using this field's name which you declare in buildForm method of your Form Class.

The errors part is working if you verify the data after submitting form in your controller.
e.g. to verify form

```
$formData = $form->getPostData();

if($form->isValid($formData)) {
    /// ...
}
```
If there are errors the error messages will be shown on bottom of every field for which you have declared validations.