$(document).ready(function(){

    needs_payment = false;

    // payment_amountElement = $("#payment_amountElement");
    payment_amountElement = $(".words:contains('Payment Amount')").next().find('input');
    payment_amountElement.attr('readonly', 'readonly');

    reunion_dinner_cost = 0;

    alumni_dinner_element   = $(".words:contains('Friday's Alumni Dinner')").next().find('select');
    alumni_dinner_selector  = $(".words:contains('Friday's Alumni Dinner')");
    attended_selector       = $(".words:contains('Attended Luther')");
    booklet_selector        = $(".words:contains('50th Reunion Booklet')");
    guest_class_selector    = $(".words:contains('Guest Class Year')");
    restrictions_selector   = $(".words:contains('dining restrictions')");
    reunion_dinner_selector = $(".words:contains('Reunion Dinner/Reception')");
    reunion_class_selector  = $(".words:contains('Reunion Class Year')");

    
    hide_initial_items();

    toggle_reunion_reservations();
    reunion_class_selector.next().find('select').change(function(){
        toggle_reunion_reservations();
    });

    toggle_dining_restrictions();
    alumni_dinner_element.change(function(){
        toggle_dining_restrictions();
        toggle_billing();
    });
    
    toggle_guest_information();
    $(".words:contains('Spouse/Guest Name')").next().find('input').blur(function(){
        toggle_guest_information();
    });

    toggle_guest_class_year();
    attended_selector.next().find('input:radio').change(function(){
        toggle_guest_class_year();
    });

    same_billing();
    $("#checkbox_same_billing").change(function(){
        same_billing();
    });

    toggle_billing();
    reunion_dinner_selector.next().find('select').change(function(){
        toggle_billing();
    });

    booklet_selector.next().find('select').change(function(){
        toggle_billing();
    });
});

function toggle_50_year_options(show_or_hide){
    if (show_or_hide == 'show')
    {
        $("#50yearreunionheaderItem").show(500);
        $(".words:contains('50th Reunion Luncheon')").parent().show(500);
        $(".words:contains('Ride in Parade')").parent().show(500);
        booklet_selector.parent().show(500);
    } else {
        $("#50yearreunionheaderItem").hide(500);
        $(".words:contains('50th Reunion Luncheon')").parent().hide(500);
        $(".words:contains('Ride in Parade')").parent().hide(500);
        booklet_selector.parent().hide(500);
    }
}

function toggle_billing(){
    if ((alumni_dinner_element.val() >= 1)
        || (reunion_dinner_selector.next().find('select').val() >= 1)
        || (booklet_selector.next().find('select').val() >= 1))
    {
        $("#hrItem").show(500);
        $("#paymentnoteItem").show(500);
        $("#paymentamountItem").show(500);
        $("#creditcardtypeItem").show(500);
        $("#creditcardnumberItem").show(500);
        $("#creditcardexpirationmonthItem").show(500);
        $("#creditcardexpirationyearItem").show(500);
        $("#creditcardnameItem").show(500);
        $("#samebillingItem").show(500);
        // $("#billingstreetaddressItem").show(500);
        // $("#billingcityItem").show(500);
        // $("#billingstateprovinceItem").show(500);
        // $("#billingzipItem").show(500);
        // $("#billingcountryItem").show(500);
        setTotal();
        needs_payment = true;
        same_billing();
    } else {
        $("#hrItem").hide(500);
        $("#paymentnoteItem").hide(500);
        $("#paymentamountItem").hide(500);
        $("#creditcardtypeItem").hide(500);
        $("#creditcardnumberItem").hide(500);
        $("#creditcardexpirationmonthItem").hide(500);
        $("#creditcardexpirationyearItem").hide(500);
        $("#creditcardnameItem").hide(500);
        $("#samebillingItem").hide(500);
        $("#billingstreetaddressItem").hide(500);
        $("#billingcityItem").hide(500);
        $("#billingstateprovinceItem").hide(500);
        $("#billingzipItem").hide(500);
        $("#billingcountryItem").hide(500);
        payment_amountElement.val("");
    }
}

function toggle_dining_restrictions(){
    if (alumni_dinner_element.val() >= 1)
    {
        restrictions_selector.parent().show(500);
    } else {
        restrictions_selector.next().find('textarea').val('');
        restrictions_selector.parent().hide(500);
    }
}

function toggle_guest_information(){
    if (!$(".words:contains('Spouse/Guest Name')").next().find('input').val())
    {
        attended_selector.parent().hide(500);
    } else {
        attended_selector.parent().show(500);        
    }
}

function toggle_guest_class_year(){
    if (attended_selector.next().find('input:radio:checked').val() == "Yes"){
        guest_class_selector.parent().show(500);
    } else {
        guest_class_selector.parent().hide(500);
    }
}

function toggle_reunion_reservations(){
    var year = (new Date).getFullYear();
    var classyear = reunion_class_selector.next().find('select').val();
    var reunion = year - classyear;
    var reunion_reservations_element = reunion_dinner_selector.parent();
    var luncheon_element = $(".words:contains('Saturday Luncheon')").parent();
    var seventieth_lunch_element = $(".words:contains('70th Reunion Dinner')").parent();

    var five_year_cost = $(".words:contains('5 year')").next().find('input').val();

    // check if this is a reunion year that has special activities and hide/show appropriate fields
    // set the reunion_dinner_cost 
    if (reunion % 5 == 0) 
    {
        $("#classreunionreservationsheaderItem").find('h4').text(classyear + ' Class Reunion Reservations');
        $("#classreunionreservationsheaderItem").show(500);
        
        if (reunion < 56) {
            reunion_dinner_cost = $(".words:contains('" + reunion + " year cost')").next().find('input').val();
        } else {
            reunion_dinner_cost = 0;
        }

    } else {
        $("#classreunionreservationsheaderItem").hide(500);
    }
    switch (reunion) 
    {
        case 75:
            luncheon_element.show(500);
            reunion_reservations_element.hide(500);
            seventieth_lunch_element.hide(500);
            toggle_50_year_options('hide');
            reunion_dinner_cost = $("input[value~='" + reunion + "'][value~='year'][value~='cost']");
            break;
        case 70:
            luncheon_element.show(500);
            reunion_reservations_element.hide(500);
            seventieth_lunch_element.show(500);
            toggle_50_year_options('hide');
            reunion_dinner_cost = $("input[value~='" + reunion + "'][value~='year'][value~='cost']");
            break;
        case 65:
            luncheon_element.show(500);
            reunion_reservations_element.hide(500);
            seventieth_lunch_element.hide(500);
            toggle_50_year_options('hide');
            reunion_dinner_cost = $("input[value~='" + reunion + "'][value~='year'][value~='cost']");
            break;
        case 60:
            luncheon_element.show(500);
            reunion_reservations_element.hide(500);
            seventieth_lunch_element.hide(500);
            toggle_50_year_options('hide');
            reunion_dinner_cost = $("input[value~='" + reunion + "'][value~='year'][value~='cost']");
            break;
        case 55:
            luncheon_element.show(500);
            reunion_reservations_element.show(500);
            seventieth_lunch_element.hide(500);
            toggle_50_year_options('hide');
            reunion_dinner_cost = $("input[value~='" + reunion + "'][value~='year'][value~='cost']");
            break;
        case 50:
            luncheon_element.show(500);
            reunion_reservations_element.show(500);
            toggle_50_year_options('show');
            seventieth_lunch_element.hide(500);
            reunion_dinner_cost = $("input[value~='" + reunion + "'][value~='year'][value~='cost']");
            break;
        case 45:
            luncheon_element.hide(500);
            reunion_reservations_element.show(500);
            seventieth_lunch_element.hide(500);
            toggle_50_year_options('hide');
            reunion_dinner_cost = $("input[value~='" + reunion + "'][value~='year'][value~='cost']");
            break;
        case 40:
            luncheon_element.hide(500);
            reunion_reservations_element.show(500);
            seventieth_lunch_element.hide(500);
            toggle_50_year_options('hide');
            reunion_dinner_cost = $("input[value~='" + reunion + "'][value~='year'][value~='cost']");
            break;
        case 35:
            luncheon_element.hide(500);
            reunion_reservations_element.show(500);
            seventieth_lunch_element.hide(500);
            toggle_50_year_options('hide');
            reunion_dinner_cost = $("input[value~='" + reunion + "'][value~='year'][value~='cost']");
            break;
        case 30:
            luncheon_element.hide(500);
            reunion_reservations_element.show(500);
            seventieth_lunch_element.hide(500);
            toggle_50_year_options('hide');
            reunion_dinner_cost = $("input[value~='" + reunion + "'][value~='year'][value~='cost']");
            break;
        case 25:
            luncheon_element.hide(500);
            reunion_reservations_element.show(500);
            seventieth_lunch_element.hide(500);
            toggle_50_year_options('hide');
            reunion_dinner_cost = $("input[value~='" + reunion + "'][value~='year'][value~='cost']");
            break;
        case 20:
            luncheon_element.hide(500);
            reunion_reservations_element.show(500);
            seventieth_lunch_element.hide(500);
            toggle_50_year_options('hide');
            reunion_dinner_cost = $("input[value~='" + reunion + "'][value~='year'][value~='cost']");
            break;
        case 15:
            luncheon_element.hide(500);
            reunion_reservations_element.show(500);
            seventieth_lunch_element.hide(500);
            toggle_50_year_options('hide');
            reunion_dinner_cost = $("input[value~='" + reunion + "'][value~='year'][value~='cost']");
            break;
        case 10:
            luncheon_element.hide(500);
            reunion_reservations_element.show(500);
            seventieth_lunch_element.hide(500);
            toggle_50_year_options('hide');
            reunion_dinner_cost = $("input[value~='" + reunion + "'][value~='year'][value~='cost']");
            break;
        case 5:
            luncheon_element.hide(500);
            reunion_reservations_element.show(500);
            seventieth_lunch_element.hide(500);
            toggle_50_year_options('hide');
            reunion_dinner_cost = $("input[value~='" + reunion + "'][value~='year'][value~='cost']");
            break;
        default:
            luncheon_element.hide(500);
            reunion_reservations_element.hide(500);
            seventieth_lunch_element.hide(500);
            toggle_50_year_options('hide');
            reunion_dinner_cost = 0;
            // toggle_billing('hide');
    }
}

function same_billing() {
    if (needs_payment == true) {
        if ($("#checkbox_same_billing").is(':checked')){
            $("#billingstreetaddressItem").hide(500);
            $("#billingcityItem").hide(500);
            $("#billingstateprovinceItem").hide(500);
            $("#billingzipItem").hide(500);
            $("#billingcountryItem").hide(500);
        } else {
            $("#billingstreetaddressItem").show(500);
            $("#billingcityItem").show(500);
            $("#billingstateprovinceItem").show(500);
            $("#billingzipItem").show(500);
            $("#billingcountryItem").show(500);
        }
    }
}

function cleanup_cost(coststring){
    if ((typeof coststring === 'undefined') || (coststring == 0 )){
        return 0;
    } else {
        //look for a dollar sign, return everything after the dollar sign
        i = coststring.indexOf('$');
        return parseInt(coststring.substring(i + 1));
    }
}

function add(){
    alumni_dinner_quantity  = 0;
    alumni_dinner_quantity  = alumni_dinner_selector.next().find('select').val();
    alumni_dinner_cost      = 0;
    alumni_dinner_cost      = cleanup_cost($('input[value~="Alumni"][value~="Dinner"][value~="cost"]').val());
    if (alumni_dinner_quantity > 0) {
        alumni_dinner_quantity = parseInt(alumni_dinner_quantity);
    } else {
        alumni_dinner_quantity = 0;    
    }
    
    reunion_dinner_quantity     = 0;
    reunion_dinner_quantity     = reunion_dinner_selector.next().find('select').val();
    if (reunion_dinner_cost != 0){
        parsed_reunion_dinner_cost  = cleanup_cost(reunion_dinner_cost.val());
    } else {
        parsed_reunion_dinner_cost = 0;
    }
    if (reunion_dinner_quantity > 0) {
        reunion_dinner_quantity = parseInt(reunion_dinner_quantity);
    } else {
        reunion_dinner_quantity = 0;
    }

    booklet_cost        = 0;
    booklet_quantity    = 0;
    booklet_cost        = cleanup_cost($('input[value~="Booklet"][value~="cost"]').val());
    booklet_quantity    = booklet_selector.next().find('select').val();
    if (booklet_quantity > 0) {
        booklet_quantity = parseInt(booklet_quantity);
    } else {
        booklet_quantity = 0;
    }

    total_cost = 0;
    total_cost = (alumni_dinner_cost * alumni_dinner_quantity) + (booklet_cost * booklet_quantity) + (parsed_reunion_dinner_cost * reunion_dinner_quantity);
    
    return total_cost;
}

function setTotal(){
    payment_amountElement.val('$' + add().toFixed(2));
    payment_amountElement.effect('highlight');
}

function hide_initial_items(){
    toggle_50_year_options('hide');
    restrictions_selector.parent().hide();
    attended_selector.parent().hide();
    guest_class_selector.parent().hide();
    $("#classreunionreservationsheaderItem").hide();
    $(".words:contains('Saturday Luncheon')").parent().hide();
    $(".words:contains('70th Reunion Dinner')").parent().hide();
    reunion_dinner_selector.parent().hide();
    $("#paymentamountItem").hide(500);
    toggle_billing();
}