<?php
/**
 * (c) Hayk Grigoryan <hayk@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FormManager\Type;

use Safan\Safan;

interface FormTypeInterface extends \Countable {

    public function setFormType($type, $options);

    public function getFormType($name);

    public function count();

}