<?php
/**
 * (c) Hayk Grigoryan <hayk@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FormManager;

use FormManager\Builder\FormBuilder;
use FormManager\View\FormView;
use Safan\Safan;

class FormManager
{
    /**
     * Available drivers
     *
     * @var array
     */
    private $dataMapper;

    /**
     * @param $params
     * @throws Exceptions\FormNotFound
     */
    public function init($params = [])
    {
        $formFactory = FormFactory::getFactory();

        $om = Safan::handler()->getObjectManager();
        $om->setObject('formManager', $formFactory);
    }

}