
<div id="admin_menu_box" class="span-4">
    <ul>
        <li>Admin Menu</li>
        <a href="<?=$base_url?>/admin/user_list">
            <li id="manage_users" class="indent">&FilledVerySmallSquare;&nbsp;&nbsp;&nbsp;Manage Users</li></a>
        <a href="<?=$base_url?>/admin/participant_list">
            <li id="manage_participants" class="indent">&FilledVerySmallSquare;&nbsp;&nbsp;&nbsp;Manage Participants</li></a>
        <a href="<?=$base_url?>/admin/plant_list">
            <li id="manage_plants" class="indent">&FilledVerySmallSquare;&nbsp;&nbsp;&nbsp;Manage Plants</li></a>
        <a href="<?=$base_url?>/admin/resource_list">
            <li id="manage_resources" class="indent">&FilledVerySmallSquare;&nbsp;&nbsp;&nbsp;Manage Resources</li></a>
        <a href="<?=$base_url?>/admin/customer_list">
            <li id="manage_customers" class="indent">&FilledVerySmallSquare;&nbsp;&nbsp;&nbsp;Manage Customers</li></a>
        <a href="<?=$base_url?>/admin/sein_list">
            <li id="manage_sein" class="indent">&FilledVerySmallSquare;&nbsp;&nbsp;&nbsp;Manage Sein</li></a>
        <a href="<?=$base_url?>/admin/fuel_type_list">
            <li id="manage_fuel_type" class="indent">&FilledVerySmallSquare;&nbsp;&nbsp;&nbsp;Manage Fuel Types</li></a>
        <a href="<?=$base_url?>/admin/region_list">
            <li id="manage_region" class="indent">&FilledVerySmallSquare;&nbsp;&nbsp;&nbsp;Manage Region</li></a>
        <a href="<?=$base_url?>/admin/holiday_list">
            <li id="manage_holiday" class="indent">&FilledVerySmallSquare;&nbsp;&nbsp;&nbsp;Manage Holidays</li></a>
        <a href="<?=$base_url?>/admin/billing_period_list">
            <li id="manage_billing_period" class="indent">&FilledVerySmallSquare;&nbsp;&nbsp;&nbsp;Manage Billing Period</li></a>
        <a href="<?=$base_url?>/admin/gate_closure_list">
            <li id="manage_gate_closure" class="indent">&FilledVerySmallSquare;&nbsp;&nbsp;&nbsp;Manage Gate Closure</li></a>    
        <a href="#">
            <li id="global_settings" class="indent">&FilledVerySmallSquare;&nbsp;&nbsp;&nbsp;Global Settings</li></a>
        <a href="<?=$base_url?>/">
            <li id="dashboard" class="indent">&FilledVerySmallSquare;&nbsp;&nbsp;&nbsp;Dashboard</li></a>
    </ul>
</div>
<script>
$.extend({
    overOn : function(id){
        $('#'+id).css('background','#4B9CDD');
    },
    overOut : function(id){
        $('#'+id).css('background','');
    }
})
</script>
<script>
$('.indent').each(function(){
    $(this).hover(
        function(){
            $.overOn($(this).attr('id'));
        },
        function(){
            $.overOut($(this).attr('id'));
        }
    );
})
</script>