<?php
/**
 * (c) Hayk Grigoryan <hayk@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FormManager\Form;

use FormManager\Builder\FormBuilderInterface;
use FormManager\Exceptions\FactoryNotFoundException;
use FormManager\FormFactory;
use FormManager\Type\FormTypeInterface;
use FormManager\Validation\FormValidation;
use FormManager\View\FormView;
use FormManager\View\FormViewInterface;
use Safan\Safan;

class Form
{
    /**
     * @var FormFactory instance
     */
    private $factory;

    /**
     * @var FormValidation instance
     */
    private $validation;
    //private $formType;
    private $view;
    private $options;

    private $formTypeName;
    private $methods = [
        'get',
        'post'
    ];

    public function __construct(FormTypeInterface $type, $options = null)
    {
        $factory = FormFactory::getFactory();

        $this->factory = $factory;
        //$this->formType = $type;
        $this->formTypeName = $type->getName();

        if(!is_null($options)) {
            $this->options = $options;
        }

        $type->buildForm($this->factory->get('builder'));
        //$this->setValidation($this->factory->get('builder')); //TODO: implement validation
        $this->view = new FormView($this->formTypeName);
    }

    public function getFormName() {
        return $this->formTypeName;
    }

    public function getFormOptions() {
        return $this->options;
    }

    public function action()
    {
        $action = $this->factory->get('builder')->get('action');
        return (string) $action;
    }

    public function method()
    {
        $method = $this->factory->get('builder')->get('method');
        return (string) $method;
    }

    public function enctype()
    {
        $enctype = $this->factory->get('builder')->get('enctype');
        return (string) $enctype;
    }

    public function row($rowName) {
        $row = $this->factory->get('builder')->get($rowName);

        return $this->view->getRow($row, $rowName);
    }

    public function setValidation(FormBuilderInterface $builder) {
        $validationData = [];

        foreach($builder->all() as $key => $builderData) {
            if(!isset($builderData['options']))
                continue;
            $options = $builderData['options'];
            if(!isset($options['validation']))
                continue;
            $validation = $builderData['options']['validation'];
            $validationData[$key] = $validation;
        }
        $this->validation = new FormValidation($validationData);
    }

    public function __call($name, $arguments)
    {
        return (string) $name;
    }


}