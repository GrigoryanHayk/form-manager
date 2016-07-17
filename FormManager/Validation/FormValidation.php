<?php
/**
 * (c) Hayk Grigoryan <hayk@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FormManager\Validation;

use Safan\Safan;


class FormValidation {

    private $data;

    public function __construct($validateData = [])
    {
        $this->data = $validateData;
    }

}

