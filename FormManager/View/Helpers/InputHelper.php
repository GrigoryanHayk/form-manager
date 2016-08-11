<?php
/**
 * (c) Hayk Grigoryan <hayk@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FormManager\View\Helpers;

trait InputHelper {

    /**
     * @param $row
     * @param $rowName
     * @return string
     */
    public function getRow($row, $rowName) {
        $type  = (!is_null($row['type']) && strlen($row['type']) > 0) ? $row['type'] : static::DEFAULT_TYPE;

        if($type == static::FIELD_TEXTAREA) {
            return $this->getTextarea($row, $rowName);
        } elseif($type == static::FIELD_BUTTON) {
            return $this->getButton($row, $rowName);
        } elseif ($type == static::FIELD_CHECKBOX) {
            return $this->getCheckbox($row, $rowName);
        } elseif ($type == static::FIELD_RADIO) {
            return $this->getRadio($row, $rowName);
        } elseif($type == static::FIELD_SELECT) {
            return $this->getSelect($row, $rowName);
        }

        $html     = "";
        $options  = isset($row['options']) ? $row['options'] : [];
        $attrs    = (!empty($options) && isset($options['attr'])) ? $options['attr'] : [];
        $id       = (!empty($attrs) && isset($attrs['id'])) ? $attrs['id'] : $this->getFormName() . '_' . $rowName;
        $fieldName     = (!empty($attrs) && isset($attrs['name'])) ? $attrs["name"] : $rowName;
        $name = $this->getFormName() . '[' . $fieldName . ']';
        $required = (!empty($attrs) && isset($attrs['required'])) ? $attrs['required'] : false;

        $label = isset($options['label']) ? $options['label'] : '';
        if(strlen($label) > 0) {
            $labelField = "<label for='".$id."' ";
            if($required != false) {
                $labelField .= "class='required'";
            }
            $labelField .= ">".$label."</label>";
            $html .= $labelField;
        }

        $html .= "<input type='". $type ."' ";
        foreach($attrs as $key => $attr) {
            if($key == static::CRITERIA_NAME)
                continue;
            $html .= $key . '="' . $attr . '" ';
        }
        if(!in_array(static::CRITERIA_ID, $attrs, true)) {
            $html .= "id='". $id ."' ";
        }
        if(!in_array(static::CRITERIA_NAME, $attrs, true)) {
            $html .= "name='". $name ."' ";
        }

        if(!empty($this->getPostData()) && array_key_exists($fieldName, $this->getPostData())) {
            $html .= "value='".$this->getPostData()[$fieldName]."' ";
        }
        $html .= "/>";

        if(!empty($this->getErrorMessages())) {
            foreach($this->getErrorMessages() as $key => $content) {
                if($key == $fieldName) {
                    $html .= '<span class="'.$id.'_error" style="color:#ff0000;font-size:0.9rem">'.$content['message'].'</span>';
                }
            }
        }

        return $html;
    }

    /**
     * @param $row
     * @param $rowName
     * @return string
     */
    private function getRadio($row, $rowName) {
        $type  = (!is_null($row['type']) && strlen($row['type']) > 0) ? $row['type'] : static::DEFAULT_TYPE;
        $name = null;
        $html = "";
        $radioValue = null;

        /**
         * Php 7 -- change to
         * $options = $row['options'] ?? [];
         * $values = $options['values'] ?? [];
         * $attr = $options['attr'] ?? [];
         */
        $options = isset($row['options']) ? $row['options'] : [];
        $values = isset($options['values']) ? $options['values'] : [];
        $attr = isset($options['attr']) ? $options['attr'] : [];

        if(count($attr) > 0 && array_key_exists(static::CRITERIA_NAME, $attr)) {
            $radioName = $attr[static::CRITERIA_NAME];
        } else {
            $radioName = $rowName;
        }

        $i = 0;
        foreach($values as $field) {
            $label = '';
            $id = $radioName . '_' . $i;
            $name = $this->getFormName() . '['. $radioName .']';
            $html .= "<div><input type='". $type ."' ";
            foreach($field as $attr => $val) {
                if($attr == static::CRITERIA_ID)
                    $id = $val;
                if($attr == static::CRITERIA_LABEL)
                    $label = $val;
                if($attr == static::CRITERIA_VALUE)
                    $radioValue = $val;
                $html .= $attr . '="' . $val . '" ';
            }

            if(!empty($this->getPostData()) && array_key_exists($radioName, $this->getPostData())) {
                if(!is_null($radioValue)) {
                    $checkedValue = $this->getPostData()[$radioName];
                    if($radioValue == $checkedValue)
                        $html .= "checked='true'";
                }
            }
            $html .= "name='".$name."' id='".$id."' required='true' />";
            $html .= "<label for='".$id."' ";
            $html .= ">".$label."</label>";

            $html .= "</div>";
            $i++;
        }
        if(!empty($this->getErrorMessages())) {
            foreach($this->getErrorMessages() as $name => $content) {
                if($name == $radioName) {
                    $html .= '<span class="'.$radioName.'_error" style="color:#ff0000;font-size:0.9rem">'.$content['message'].'</span>';
                }
            }
        }

        return $html;
    }

    /**
     * @param $row
     * @param $rowName
     * @return string
     */
    private function getCheckbox($row, $rowName) {
        $type  = (!is_null($row['type']) && strlen($row['type']) > 0) ? $row['type'] : static::DEFAULT_TYPE;
        $html = "";
        $checkboxValue = null;

        /**
         * Php 7 -- change to
         * $options = $row['options'] ?? [];
         * $attr = $options['attr'] ?? [];
         * $label = $options['label'] ?? '';
         */
        $options = isset($row['options']) ? $row['options'] : [];
        $attr = isset($options['attr']) ? $options['attr'] : [];
        $label = isset($options['label']) ? $options['label'] : '';

        if(count($attr) > 0 && array_key_exists(static::CRITERIA_NAME, $attr)) {
            $checkboxName = $attr[static::CRITERIA_NAME];
        } else {
            $checkboxName = $rowName;
        }
        $name = $this->getFormName() . '['. $checkboxName .']';
        $id = $this->getFormName() . '_' . $checkboxName;

        $html .= "<div><input type='". $type ."' ";
        foreach($attr as $key => $val) {
            if($key == static::CRITERIA_NAME)
                continue;
            if($key == static::CRITERIA_VALUE)
                $checkboxValue = $val;
            $html .= $key . '="' . $val . '" ';
        }

        if(!empty($this->getPostData()) && array_key_exists($checkboxName, $this->getPostData())) {
            if(!is_null($checkboxValue)) {
                $checkedValue = $this->getPostData()[$checkboxName];
                if($checkboxValue == $checkedValue)
                    $html .= "checked='true'";
            }
        }
        $html .= "name='".$name."' id='".$id."' />";
        $html .= "<label for='".$id."' ";
        $html .= ">".$label."</label>";

        $html .= "</div>";
        if(!empty($this->getErrorMessages())) {
            foreach($this->getErrorMessages() as $name => $content) {
                if($name == $checkboxName) {
                    $html .= '<span class="'.$checkboxName.'_error" style="color:#ff0000;font-size:0.9rem">'.$content['message'].'</span>';
                }
            }
        }

        return $html;
    }

}