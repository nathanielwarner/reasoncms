<?php
reason_include_once('minisite_templates/modules/form/views/thor/luther_default.php');
$GLOBALS['_form_view_class_names'][basename(__FILE__, '.php')] = 'RoyalVisitThorForm';

class RoyalVisitThorForm extends LutherDefaultThorForm {

    function on_every_time() {
        parent::on_every_time();

        $herp_element = $this->get_element_name_from_label('Herp');
        $this->change_element_type($herp_element, 'colorpicker');
    }
}
?>