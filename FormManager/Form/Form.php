<?php
/**
 * (c) Hayk Grigoryan <hayk@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FormManager\Form;

use FormManager\Builder\FormBuilderInterface;
use FormManager\FormFactory;
use FormManager\Type\FormTypeInterface;
use FormManager\Validation\FormValidation;
use FormManager\View\FormView;

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
        $this->formTypeName = $type->getName();

        if(!is_null($options)) {
            $this->options = $options;
        }

        $type->buildForm($this->factory->get('builder'));
        $this->setValidation($this->factory->get('builder'));
        $this->view = new FormView($this->formTypeName);
    }

    /**
     * @return mixed
     */
    public function getFormName() {
        return $this->formTypeName;
    }

    /**
     * @return mixed
     */
    public function getFormOptions() {
        return $this->options;
    }

    /**
     * @description set form action
     * @return string
     */
    public function action()
    {
        $action = $this->factory->get('builder')->get('action');
        return (string) $action;
    }

    /**
     * @description set form method
     * @return string
     */
    public function method()
    {
        $method = $this->factory->get('builder')->get('method');
        return (string) $method;
    }

    /**
     * @description set form enctype
     * @return string
     */
    public function enctype()
    {
        $enctype = $this->factory->get('builder')->get('enctype');
        return (string) $enctype;
    }

    /**
     * @param $rowName
     * @return string
     */
    public function row($rowName) {
        $row = $this->factory->get('builder')->get($rowName);
        return $this->view->getRow($row, $rowName);
    }

    /**
     * @param FormBuilderInterface $builder
     */
    public function setValidation(FormBuilderInterface $builder) {
        $validationData = [];

        foreach($builder->all() as $key => $builderData) {
            if(!isset($builderData['options']))
                continue;
            $options = $builderData['options'];
            if(!isset($options['validation']))
                continue;
            /**
             * Change for PHP 7, $optionsAttr = $options['attr'] ?? [];
             */
            $optionsAttr = $options['attr'] ? $options['attr'] : [];
            if(isset($optionsAttr["name"]))
                $key = $optionsAttr["name"];
            $validation = $builderData['options']['validation'];
            $validationData[$key] = $validation;
        }
        $this->validation = new FormValidation($validationData);
    }

    /**
     * @return FormValidation
     */
    public function getValidation() {
        return $this->validation;
    }

    /**
     * @description get POST data from Request
     * @return mixed
     */
    public function getPostData() {
        $postContent = $_POST;
        return isset($postContent[$this->getFormName()]) ? $postContent[$this->getFormName()] : null; // in php7 version $postContent[$this->getFormName()] ?? null
    }

    /**
     * @description get Get data from Request
     * @return mixed
     */
    public function getGetData() {
        $getContent = $_GET;
        return isset($getContent[$this->getFormName()]) ? $getContent[$this->getFormName()] : null; // in php7 version $getContent[$this->getFormName()] ?? null
    }

    /**
     * @param $data
     * @return bool
     */
    public function isValid($data) {
        return $this->validation->isValid($data);
    }

    /**
     * @return array
     */
    public function getFormErrors() {
        return $this->validation->getErrorMessages();
    }

    /**
     * Set formData and ErrorMessages
     */
    public function formErrors() {
        $this->view->setPostData($this->getPostData());
        $this->view->setFormErrors($this->getFormErrors());
    }

    /**
     * @param $name
     * @param $arguments
     * @return string
     */
    public function __call($name, $arguments)
    {
        return (string) $name;
    }


}