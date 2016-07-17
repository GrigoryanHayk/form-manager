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
use FormManager\Exceptions\FormTypeNotFound;
use FormManager\Form\Form;
use FormManager\Type\FormTypeInterface;
use FormManager\View\FormView;
use FormManager\View\FormViewInterface;
use Safan\Safan;

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
    private $factory = [
        'formTypes' => []
    ];

    private function __construct() {}

    private function __clone() {}

    public static function getFactory()
    {
        if(is_null(self::$instance)) {
            self::$instance = new self;
            self::$instance->setBuilder(new FormBuilder());
        }
        return self::$instance;
    }

    public function setBuilder(FormBuilderInterface $formBuilder, $options = [])
    {
        $this->factory['builder'] = $formBuilder;
    }

    public function get($name)
    {
        return $this->factory[$name];
    }

    public function generateForm(FormTypeInterface $type, $options = null)
    {
        //$builder = $type->buildForm();
        //$this->setBuilder();
        $this->setType($type, $options);
        return $this->getForm($type, $options);
    }

    public function setType(FormTypeInterface $type, $options = null)
    {
        if(method_exists($type, 'getName')) {
            if(!array_key_exists($type->getName(), $this->factory['formTypes'])) {
                $this->factory['formTypes'][$type->getName()] = $type;
            }
        } else {
            throw new FormTypeNotFound("You must implement getName() for the type of Form, it must return @string");
        }
    }

    public function getType($name)
    {
        return $this->factory['formTypes'][$name];
    }

    public function getForm($type, $options = null)
    {
        return new Form($type, $options);
    }


}