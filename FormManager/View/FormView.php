<?php
/**
 * (c) Hayk Grigoryan <hayk@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FormManager\View;

use FormManager\Exceptions\FormNameNotFoundException;
use FormManager\View\Helpers\MainHelper;
use Safan\Safan;

class FormView implements FormViewInterface {

    use MainHelper;

    const DEFAULT_TYPE      = 'text';
    const DEFAULT_ENCTYPE   = 'multipart/form-data';

    const FIELD_TEXT        = 'text';
    const FIELD_EMAIL       = 'email';
    const FIELD_PASSWORD    = 'password';
    const FIELD_FILE        = 'file';
    const FIELD_CHECKBOX    = 'checkbox';
    const FIELD_RADIO       = 'radio';
    const FIELD_SUBMIT      = 'submit';
    const FIELD_TEXTAREA    = 'textarea';
    const FIELD_BUTTON      = 'button';

    const CRITERIA_ID       = 'id';
    const CRITERIA_NAME     = 'name';
    const CRITERIA_VALUE    = 'value';
    const CRITERIA_REQUIRED = 'required';
    const CRITERIA_DISABLED = 'disabled';


    private $formName;

    private $enctypes = [
        'text/plain',
        'application/x-www-form-urlencoded',
        'multipart/form-data',
    ];

    public function __construct($formName)
    {
        if($formName)
            $this->formName = $formName;
        else 
            throw new FormNameNotFoundException('The Form View Has Dependency of formName for settings');
    }

    public function getFormName()
    {
        return $this->formName;
    }

}