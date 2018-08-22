<?php include $site_path.'/tpl/menu.php' ?>
<div class="span-19" id="content-holder">
    <fieldset class="fs-blue">
        <legend>Upload Plant Availability</legend>
        <input type="file">
        <button>Submit</button>
    </fieldset>
    <fieldset class="fs-blue">
        <legend>Choose Report</legend>
        <table class="span-12">
            <tr>
                <td>Delivery Date:</td>
                <td><input type="text" class="text span-4"></td>

                <td>Report type:</td>
                <td>
                    <select>
                        <option>DAP</option>
                        <option>WAP</option>
                    </select>
                </td>
            </tr>
        </table>
    </fieldset>    
    <fieldset class="fs-blue">
        <legend>Populate Report</legend>
    <table class="span-20">
        <tr>
            <td>
                Choose Plant:
                <select>
                    <option>Plant 1</option>
                    <option>Plant 2</option>
                </select>
            </td>
            <td>
                Choose Plant:
                <select>
                    <option>Unit 1</option>
                    <option>Unit 2</option>
                </select>
            </td>
            <td>Interval:&nbsp;<input type="text" value="1-24" class="small"></td>
            <td>
                Reason:
                <select>
                    <option>reason 1</option>
                    <option>reason 2</option>
                </select>
            </td>
            <td><button>Apply</button><button>Clear</button></td>
        </tr>
    </table>
    </fieldset>
    <fieldset class="fs-blue">
        <legend></legend>
        <table class="span-24">
            <tr>
                <td colspan="3" class="tb_header">
                    Generated Capacity for 
                    <br>Plant: Plant1 Unit: Unit1 
                    <br>Delivery Date: <?=date('M, d Y')?>
                </td>
            </tr>
            <tr>
                <td class="bg_black">Interval</td>
                <td class="bg_black">Generated Capacity</td>
                <td class="bg_black">Reason</td>
            </tr>
            <?php
            foreach(json_decode($int_obj) as $i=>$int) {

                echo '
                        <tr style="padding:5px">
                            <td class="bg_white">'.$int->interval.' ('.$int->start.'-'.$int->end.'H)</td>
                            <td class="bg_white"><input class="smalltxtbox"> MW</td>
                            <td class="bg_white">
                                <select>
                                    <option>reason 1</option>
                                    <option>reason 2</option>
                                </select>
                            </td>
                        </tr>
                        ';
            }
            ?>
        </table>
    </fieldset>
    <button>Confirm Plant Availability</button>
</div>
