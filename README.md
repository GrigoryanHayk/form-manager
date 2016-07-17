Form Manager
===============
Form Manager for managing and building forms

REQUIREMENTS
------------
PHP > 5.4.0

INSTALLATION
------------
If you're using [Composer](http://getcomposer.org/) for your project's dependencies, add the following to your "composer.json":
```
"require": {
    "safan-lab/form-manager": "1.*"
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

