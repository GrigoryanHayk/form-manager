<?php
/**
 * (c) Hayk Grigoryan <hayk@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FormManager\Builder;

use Safan\Safan;

interface FormBuilderInterface extends \Countable {

    public function addAction($action);

    public function add($child, $type = null, array $options = []);

    public function create($name, $type = null, array $options = []);

    public function get($name);

    public function remove($name);

    public function has($name);

    public function all();

    public function getForm();
}