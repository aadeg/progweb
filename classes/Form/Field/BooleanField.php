<?php
namespace Form\Field;

class BooleanField extends BaseInputField {
    const INPUT_TYPE = 'checkbox';

    private $labelPost; // Se true, la label verrà visualizzata dopo l'input

    public function __construct($name, $label, $moreAttribs=array(),
                                $labelPost=false){
        parent::__construct(self::INPUT_TYPE, $name, $label, $moreAttribs);
        $this->labelPost = $labelPost;
    }

    public function html($value=null, $withLabel=true){
        if (!$this->labelPost || !$withLabel)
            return parent::html($value, $withLabel);

        $html = parent::html($value, false);
        return "<label>{$html} {$this->label}</label>";
    }
}