<?php
/**
 * (c) Hayk Grigoryan <hayk@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FormManager;

use FormManager\Builder\FormBuilder;
use FormManager\Builder\FormBuilderInterface;
use FormManager\Exceptions\FormTypeNotFoundException;
use FormManager\Form\Form;
use FormManager\Type\FormTypeInterface;

/**
 * Singleton Class FormFactory
 * @package FormManager
 */
class FormFactory
{
    /**
     * @var $instance
     */
    private static $instance;
    /**
     * @var array
     */
    private $factory = [
        'formTypes' => []
    ];

    private function __construct() {}

    private function __clone() {}

    /**
     * @return FormFactory
     */
    public static function getFactory()
    {
        if(is_null(self::$instance)) {
            self::$instance = new self;
            self::$instance->setBuilder(new FormBuilder());
        }
        return self::$instance;
    }

    /**
     * @param FormBuilderInterface $formBuilder
     * @param array $options
     */
    public function setBuilder(FormBuilderInterface $formBuilder, $options = [])
    {
        $this->factory['builder'] = $formBuilder;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->factory[$name];
    }

    /**
     * @param FormTypeInterface $type
     * @param null $options
     * @return Form
     */
    public function generateForm(FormTypeInterface $type, $options = null)
    {
        $this->setType($type, $options);
        return $this->getForm($type, $options);
    }

    /**
     * @param FormTypeInterface $type
     * @param null $options
     */
    public function setType(FormTypeInterface $type, $options = null)
    {
        if(method_exists($type, 'getName')) {
            if(!array_key_exists($type->getName(), $this->factory['formTypes'])) {
                $this->factory['formTypes'][$type->getName()] = $type;
            }
        } else {
            throw new FormTypeNotFoundException("You must implement getName() for the type of Form, it must return @string");
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getType($name)
    {
        return $this->factory['formTypes'][$name];
    }

    /**
     * @param $type
     * @param null $options
     * @return Form
     */
    public function getForm($type, $options = null)
    {
        return new Form($type, $options);
    }


}