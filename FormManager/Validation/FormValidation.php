<?php
/**
 * (c) Hayk Grigoryan <hayk@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FormManager\Validation;

class FormValidation {
    /**
     * @var array data from Request
     */
    private $data;

    /**
     * @var array
     */
    private $errorMessages = [];

    const VALID_MESSAGE   = 'message';
    const VALID_CALLBACK  = 'callback';
    const VALID_MIN       = 'min';
    const VALID_MAX       = 'max';
    const VALID_MAXLENGTH = 'maxlength';
    const DEFAULT_MIN_MESSAGE = 'The minimum length of the field must be %s';
    const DEFAULT_MAX_MESSAGE = 'The maximum length of the field must be %s';

    public function __construct($validateData = []) {
        $this->data = $validateData;
    }

    /**
     * @return array data from Request
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @description Check is Form valid and sets errorMessages
     * @param $data
     * @return bool
     */
    public function isValid($data) {
        if(empty($data))
            return false;

        foreach($data as $fieldName => $item) {
            if(array_key_exists($fieldName, $this->getData())) {
                $validOptions = $this->getData()[$fieldName];

                if(array_key_exists(self::VALID_MIN, $validOptions)) {
                    $this->validMin($validOptions, $item, $fieldName);
                }
                if(array_key_exists(self::VALID_MAX, $validOptions)) {
                    $this->validMax($validOptions, $item, $fieldName);
                }
                if(array_key_exists(self::VALID_CALLBACK, $validOptions)) {
                    if(!$validOptions[self::VALID_CALLBACK]($item))
                        $this->errorMessages[$fieldName]['message'] = $validOptions[self::VALID_MESSAGE];
                }
            }
        }
        if(empty($this->errorMessages))
            return true;
        else
            return false;
    }

    /**
     * @description return errorMessages form FormBuilder
     * @return array
     */
    public function getErrorMessages() {
        return $this->errorMessages;
    }

    /**
     * @param $validOptions
     * @param $item
     * @param $fieldName
     */
    private function validMin($validOptions, $item, $fieldName) {
        if(strlen($item) < (int) $validOptions[self::VALID_MIN]) {
            $this->errorMessages[$fieldName]['message'] = isset($validOptions[self::VALID_MESSAGE]) ? $validOptions[self::VALID_MESSAGE] : str_replace('%s', $validOptions[self::VALID_MIN], self::DEFAULT_MIN_MESSAGE);
        }
    }

    /**
     * @param $validOptions
     * @param $item
     * @param $fieldName
     */
    private function validMax($validOptions, $item, $fieldName) {
        if(strlen($item) > (int) $validOptions[self::VALID_MAX]) {
            $this->errorMessages[$fieldName]['message'] = isset($validOptions[self::VALID_MESSAGE]) ? $validOptions[self::VALID_MESSAGE] : str_replace('%s', $validOptions[self::VALID_MAX], self::DEFAULT_MAX_MESSAGE);
        }
    }

}

