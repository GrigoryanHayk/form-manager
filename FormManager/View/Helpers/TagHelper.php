<?php
/**
 * (c) Hayk Grigoryan <hayk@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FormManager\View\Helpers;

trait TagHelper {

    /**
     * @param $row
     * @param $rowName
     * @return string
     */
    private function getButton($row, $rowName) {
        $html     = "";

        $options  = isset($row['options']) ? $row['options'] : [];
        $attrs    = (!empty($options) && isset($options['attr'])) ? $options['attr'] : [];
        $id       = (!empty($attrs) && isset($attrs['id'])) ? $attrs['id'] : $this->getFormName() . '_' . $rowName;
        $name     = (!empty($attrs) && isset($attrs['name'])) ? $this->getFormName().'['.$attrs["name"].']' : $this->getFormName().'['. $rowName.']';
        $text     = (!empty($attrs) && isset($attrs['text'])) ? $attrs['text'] : '';
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

        $html .= "<button ";
        foreach($attrs as $key => $attr) {
            $html .= $key . '="' . $attr . '" ';
        }

        // Settings Default id and name if not exists in Builder options
        if(!in_array(static::CRITERIA_ID, $attrs, true)) {
            $html .= "id='". $id ."' ";
        }
        if(!in_array(static::CRITERIA_NAME, $attrs, true)) {
            $html .= "name='". $name ."' ";
        }
        $html .= ">".$text."</button>";

        return $html;
    }

    /**
     * @param $row
     * @param $rowName
     * @return string
     */
    private function getTextarea($row, $rowName) {
        $html = "";

        $options = isset($row['options']) ? $row['options'] : [];
        $attrs   = (!empty($options) && isset($options['attr'])) ? $options['attr'] : [];
        $id    = (!empty($attrs) && isset($attrs['id'])) ? $attrs['id'] : $this->getFormName() . '_' . $rowName;
        $name  = (!empty($attrs) && isset($attrs['name'])) ? $this->getFormName().'['.$attrs["name"].']' : $this->getFormName().'['.$rowName.']';
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

        $html .= "<textarea ";
        foreach($attrs as $key => $attr) {
            $html .= $key . '="' . $attr . '" ';
        }

        // Settings Default id and name if not exists in Builder options
        if(!in_array(static::CRITERIA_ID, $attrs, true)) {
            $html .= "id='". $id ."' ";
        }
        if(!in_array(static::CRITERIA_NAME, $attrs, true)) {
            $html .= "name='". $name ."' >";
        }
        if(!empty($this->getPostData()) && array_key_exists($rowName, $this->getPostData())) {
            $html .= $this->getPostData()[$rowName];
        }
        $html .= "</textarea>";
        if(!empty($this->getErrorMessages())) {
            foreach($this->getErrorMessages() as $name => $content) {
                if($name == $rowName) {
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
    private function getSelect($row, $rowName) {
        $type  = (!is_null($row['type']) && strlen($row['type']) > 0) ? $row['type'] : static::DEFAULT_TYPE;
        $name = null;
        $html = "";

        /**
         * Php 7 -- change to
         * $options = $row['options'] ?? [];
         * $selectOptions = $options['values'] ?? [];
         * $attr = $options['attr'] ?? [];
         * $id = $attr['id'] ?? $this->getFormName() . '_' . $rowName;
         */
        $options = isset($row['options']) ? $row['options'] : [];
        $selectOptions = isset($options['options']) ? $options['options'] : [];
        $attr = isset($options['attr']) ? $options['attr'] : [];
        $id = isset($attr['id']) ? $attr['id'] : $this->getFormName() . '_' . $rowName;

        if(count($attr) > 0 && array_key_exists(static::CRITERIA_NAME, $attr)) {
            $selectName = $attr[static::CRITERIA_NAME];
        } else {
            $selectName = $rowName;
        }

        $name = $this->getFormName() . '[' . $selectName . ']';

        $html .= "<div><select name='".$name."' ";
        if(!is_null($id))
            $html .= "id=" . $id . " ";
        foreach($attr as $k => $v) {
            $html .= $k."=".$v." ";
        }
        $html .= ">";

        foreach($selectOptions as $field) {
            foreach($field as $value => $label) {
                $html .= "<option value=".$value." ";

                if(!empty($this->getPostData()) && array_key_exists($selectName, $this->getPostData())) {
                    if(!is_null($value)) {
                        $selectedValue = $this->getPostData()[$selectName];
                        if($value == $selectedValue)
                            $html .= "selected='true' ";
                    }
                }
                $html .= ">";
                $html .= $label . "</option>";
            }
        }
        $html .= "</select>";
        $html .= "</div>";
        if(!empty($this->getErrorMessages())) {
            foreach($this->getErrorMessages() as $name => $content) {
                if($name == $selectName) {
                    $html .= '<span class="'.$selectName.'_error" style="color:#ff0000;font-size:0.9rem">'.$content['message'].'</span>';
                }
            }
        }
        return $html;
    }

}

