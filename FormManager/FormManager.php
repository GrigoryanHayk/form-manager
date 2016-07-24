<?php
/**
 * (c) Hayk Grigoryan <hayk@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FormManager;

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
     * @param array $params
     */
    public function init($params = [])
    {
        $formFactory = FormFactory::getFactory();

        $om = Safan::handler()->getObjectManager();
        $om->setObject('formManager', $formFactory);
    }

}