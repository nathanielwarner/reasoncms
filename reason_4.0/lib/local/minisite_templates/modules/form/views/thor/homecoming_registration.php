<?php

reason_include_once('minisite_templates/modules/form/views/thor/credit_card_with_no_payment_option.php');
include_once(WEB_PATH . 'stock/pfproclass.php');

$GLOBALS['_form_view_class_names'][basename(__FILE__, '.php')] = 'HomecomingRegistrationForm';

/**
 * Form view for the homecoming registration process.
 * 
 * This form view allows the form builder (Alumni) to change their prices from year to year
 * without needing the involvement of a developer.
 * 
 * The form builder needs to include hidden fields with the value of the field having the 
 * following format for the charged reunion dinners/receptions:
 * 
 *      '5 year cost = $25'
 * 
 * Hidden fields for the 50 year booklet and Friday's Alumni Dinner are also needed.
 * 
 * Since the total is changed and displayed via javascript, a check is done during the
 * run_error_checks phase to make sure the math adds up and that the total wasn't manipulated
 * manually by the end-user.
 * 
 * 
 * @package reason_package_local
 * @subpackage thor_view
 * @author Steve Smith
 */
class HomecomingRegistrationForm extends CreditCardNoPaymentThorForm {
    function custom_init() 
    { 
        $model =& $this->get_model(); 
        $head_items = $model->get_head_items(); 
        $head_items->add_javascript('/reason/local/js/form/homecoming_registration.js');
        $head_items->add_javascript(JQUERY_UI_URL);
        $head_items->add_stylesheet(JQUERY_UI_CSS_URL);
    } 

    // style up the form and add comments et al
    function on_every_time() 
    {
        parent :: on_every_time(); 
        $this->add_element('your_information_header', 'comment', array('text'=>'<h4>Your Information</h4>'));
        $this->move_element('your_information_header', 'before', $this->get_element_name_from_label('Current First Name'));
        $this->add_element('guest_information_header', 'comment', array('text'=>'<h4>Spouse/Guest Information</h4>'));
        $this->move_element('guest_information_header', 'before', $this->get_element_name_from_label('Spouse/Guest Name'));
        $this->add_element('alumni_dinner_header', 'comment', array('text'=>'<h4>Alumni Dinner Reservations</h4>'));
        $this->move_element('alumni_dinner_header', 'before', $this->get_element_name_from_label('Friday\'s Alumni Dinner'));
        $this->add_element('class_reunion_reservations_header', 'comment', array('text'=>'<h4>Class Reunion Reservations</h4>'));
        $this->move_element('class_reunion_reservations_header', 'after', $this->get_element_name_from_label('Friday\'s Alumni Dinner'));
        $this->add_element('50_year_reunion_header', 'comment', array('text'=>'<h4>50 Year Reunion</h4>'));
        $this->move_element('50_year_reunion_header', 'before', $this->get_element_name_from_label('50th Reunion Luncheon'));
        $class_year = $this->get_element_name_from_label('Reunion Class Year');
          $this->change_element_type($class_year, 'year', array('num_years_before_today'=>'75','num_years_after_today'=>'-1'));
        $attended_luther = $this->get_element_name_from_label('Attended Luther');
        $this->change_element_type($attended_luther, 'radio_inline_no_sort');
        $guest_class_year = $this->get_element_name_from_label('Guest Class Year');
          $this->change_element_type($guest_class_year, 'year', array('num_years_before_today'=>'75','num_years_after_today'=>'-1'));
        $dining_restrictions = $this->get_element_name_from_label('Dining Restrictions?');
        $this->change_element_type($dining_restrictions, 'textarea', array('display_name'=>
          'Do you or any of your guests have any dining restrictions?'));
        $parade = $this->get_element_name_from_label('Ride in Parade?');
        $this->change_element_type($parade, 'radio_inline_no_sort');
        $this->add_element('hr', 'hr');
        $this->move_element('hr', 'after', $this->get_element_name_from_label('50th Reunion Booklet'));
        $this->add_element('same_billing', 'checkboxfirst', array('display_name' => 'Billing address is same as above'));
        $this->move_element('same_billing', 'after', 'credit_card_name');
    }

    /**
     * Cleans any extra characters form the hidden field values and returns an int
     * 
     * @param string The cost string
     * @return int The cost cleaned (all chars removed and an int returned)
     */
    private function _cleanup_cost($cost)
    {
        $c = explode('$', $cost);
        $ret = substr($c[1], 0);
        return intval($ret);
    }

    /**
     * Figure the total cost based on the options
     * 
     * @return string The total for all charges 
     */
    function get_amount()
    {

        $five_cost          = $this->_cleanup_cost($this->get_value_from_label('5 year cost'));
        $ten_cost           = $this->_cleanup_cost($this->get_value_from_label('10 year cost'));
        $fifteen_cost       = $this->_cleanup_cost($this->get_value_from_label('15 year cost'));
        $twenty_cost        = $this->_cleanup_cost($this->get_value_from_label('20 year cost'));
        $twentyfive_cost    = $this->_cleanup_cost($this->get_value_from_label('25 year cost'));
        $thirty_cost        = $this->_cleanup_cost($this->get_value_from_label('30 year cost'));
        $thirtyfive_cost    = $this->_cleanup_cost($this->get_value_from_label('35 year cost'));
        $forty_cost         = $this->_cleanup_cost($this->get_value_from_label('40 year cost'));
        $fortyfive_cost     = $this->_cleanup_cost($this->get_value_from_label('45 year cost'));
        $fifty_cost         = $this->_cleanup_cost($this->get_value_from_label('50 year cost'));
        $fiftyfive_cost     = $this->_cleanup_cost($this->get_value_from_label('55 year cost'));
        $booklet_cost       = $this->_cleanup_cost($this->get_value_from_label('Booklet cost'));
        $alumni_dinner_cost = $this->_cleanup_cost($this->get_value_from_label('Alumni Dinner cost'));

        $reunion_cost = 0;

        $total = 0;

        $class_year = intval($this->get_value_from_label('Reunion Class Year'));
        $cur_year = idate('Y');
        $is_reunion_year = ($cur_year - $class_year) % 5;
        if ($is_reunion_year == 0) {
            $reunion = $cur_year - $class_year;
            switch ($reunion) {
                case '5':
                    $reunion_cost = $five_cost;
                    break;
                case '10':
                    $reunion_cost = $ten_cost;
                    break;
                case '15':
                    $reunion_cost = $fifteen_cost;
                    break;
                case '20':
                    $reunion_cost = $twenty_cost;
                    break;
                case '25':
                    $reunion_cost = $twentyfive_cost;
                    break;
                case '30':
                    $reunion_cost = $thirty_cost;
                    break;
                case '35':
                    $reunion_cost = $thirtyfive_cost;
                    break;
                case '40':
                    $reunion_cost = $forty_cost;
                    break;
                case '45':
                    $reunion_cost = $fortyfive_cost;
                    break;
                case '50':
                    $reunion_cost = $fifty_cost;
                    break;
                case '55':
                    $reunion_cost = $fiftyfive_cost;
                    break;
                default:
                    $reunion_cost = 0;
                    break;
            }
        } 

        $total = 0;
        $total = (($alumni_dinner_cost * intval($this->get_value_from_label('Friday\'s Alumni Dinner')))
                + ($reunion_cost * intval($this->get_value_from_label('Reunion Dinner/Reception')))
                + ($booklet_cost * intval($this->get_value_from_label('50th Reunion Booklet'))));
        return $total;
    }

    function pre_error_check_actions()
    {
        // make the address fields required if "Same address as above is selected"
        // set the billing info based on that info
        if ($this->get_value('same_billing') == true)
        {
            // remove from required so we don't show redundant error messages
            $this->remove_required('billing_street_address');
            $this->remove_required('billing_city');
            $this->remove_required('billing_state_province');
            $this->remove_required('billing_zip');

            // Add error messages if "Same address as above" is checked
            // if the information is not provided check for address fields
            if ($this->get_value_from_label('Address') == "")
            {
                $this->set_error($this->get_element_name_from_label('Address'), 'Since you checked "Billing address same as above", the Address field is required');
            } else {
                $this->set_value('billing_street_address', $this->get_value_from_label('Address'));
            }
            if ($this->get_value_from_label('City') == "")
            {
                $this->set_error($this->get_element_name_from_label('City'), 'Since you checked "Billing address same as above", the City field is required');
            } else {
                $this->set_value('billing_city', $this->get_value_from_label('City'));
            }
            if ($this->get_value_from_label('State/Province') == "")
            {
                $this->set_error($this->get_element_name_from_label('State/Province'), 'Since you checked "Billing address same as above", the State/Province field is required');
            } else {
                $this->set_value('billing_state_province', $this->get_value_from_label('State/Province'));
            }
            if ($this->get_value_from_label('Zip/Postal Code') == "")
            {
                $this->set_error($this->get_element_name_from_label('Zip/Postal Code'), 'Since you checked "Billing address same as above", the Zip/Postal Code field is required');
            } else {
                $this->set_value('billing_zip', $this->get_value_from_label('Zip/Postal Code'));
            }
        }
        parent::pre_error_check_actions();
    }

    function run_error_checks()
    {
        // Check for javascript manipulation of the payment amount
        // strip the dollar sign from the payment amount
        $pa = $this->get_value_from_label('Payment Amount');
        $pay_amount = substr($pa, 1);

        if ($pay_amount != floatval($this->get_amount()))
        {
            $pa_element = $this->get_element_name_from_label('Payment Amount');
            $this->set_error($pa_element, '<strong>Incorrect Payment Amount</strong>. The amount set in the payment amount field does not equal the cost for all chosen options. Please check your math or <a href="http://enable-javascript.com/" target="_blank">enable javascript</a> to have the form automatically fill in this field.<br>');
        }
        parent :: run_error_checks();

        if (isset($this->pfresult['PNREF']))
        {
            $this->set_value($this->get_element_name_from_label('REFNUM'), $this->pfresult['PNREF']);
        } else {
            $this->set_value($this->get_element_name_from_label('REFNUM'), '');
        }
    }
}