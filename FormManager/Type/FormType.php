<?php
/**
 * (c) Hayk Grigoryan <hayk@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FormManager\Type;

use FormManager\Builder\FormBuilderInterface;
use FormManager\Exceptions\FormTypeNotFoundException;
use FormManager\View\FormViewInterface;

abstract class FormType implements FormTypeInterface {
    /**
     * storage of formTypes
     * @var array
     */
    private $formTypes = [];

    /**
     * @param $type
     * @param null $options
     * @throws FormTypeNotFoundException
     */
    public function setFormType($type, $options = null) {
        if(method_exists($type, 'getName'))
            $this->formTypes[$type->getName()] = $type;
        else
            throw new FormTypeNotFoundException("The Form Type Class must implement 'getName' to return the name for mapping.");
    }
    /**
     * Return the formType Object from storage
     * // Ternary operator used like this method to keep dependency with PHP version you use.
     * // It can be changed like PHP 7 return $this->formTypes[$name] ?? null
     * @param $name
     * @return mixed|null
     */
    public function getFormType($name)
    {
        return isset($this->formTypes[$name]) ?
                            $this->formTypes[$name] :
                            null;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'form';
    }

    /**
     * @param FormBuilderInterface $builder
     * @return mixed
     */
    public abstract function buildForm(FormBuilderInterface $builder);

    /**
     * @param FormViewInterface $formView
     * @param $options
     */
    public function buildView(FormViewInterface $formView, $options)
    {
        $formView->generateView($options);
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return count($this->formTypes);
    }

}