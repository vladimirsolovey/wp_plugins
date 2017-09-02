<?php
use SoundCloud\classes\cron\HF_SoundCloud_Cron;
use SoundCloud\classes\metabox\HF_SoundCloud_MetaBox;

$cron_instance = HF_SoundCloud_Cron::getInstance();

$current_frequency = $obj->getFq()?$obj->getFq():"daily";
$current_fq_day = $obj->getFqDay();

$current_fq_hour = $obj->getFqHour();
$current_fq_month = $obj->getFqMonth();

?>
<script type="text/javascript">
    $j = jQuery.noConflict();
    $j(document).ready(function(){


        $j("#frequency").change(function(){
            initTimeScheduler($j(this).attr('id'),$j(this).val());
        });
        initTimeScheduler("frequency",'<?php echo $current_frequency;?>','<?php echo $current_fq_month;?>','<?php echo $current_fq_day;?>','<?php echo $current_fq_hour;?>');
    });

    function initTimeScheduler(continerId,fq,month,day,hour)
    {
        var scheduler_config_id = $j("#"+$j("#"+continerId).attr("data-scheduler-config-id"));
        fq = fq||false;

        console.log(fq);
        if(fq && fq!='every3hours' && fq!='every30minutes')
        {

            scheduler_config_id.empty();

            var html = '<th><label>Schedule</label></th>';
            var start_text = 'Import runs __FQ__';
            var end_text  = 'at approximately';
            var fq_str = fq[0].toUpperCase()+fq.slice(1).toLowerCase();

            html+='<td><ul class="hf-sc-schedule-period">';
            html+='<li>'+start_text.replace(/__FQ__/g,fq_str)+'</li>';
            switch(fq)
            {
                case 'weekly':

                    html+='<li>on '+getDays(day);+'</li>';
                    break;
                case 'monthly':
                    html+='<li>on '+getMonths(month)+'</li>';
                    break;
            }

            html+='<li>'+end_text+' '+getHours(hour)+'</li>';
            html+='</ul><td>';

            scheduler_config_id.append(html);

        }
        else
        {
            scheduler_config_id.empty();
        }
    }

    function getHours(hour)
    {
        var hours =[];
        hour = hour||false;
        for(var h=0 ;h<=23;h++)
        {
            var am_pm = "am";
            var h_tmp = h;
            if(h>12)
            {
                am_pm = "pm";
                h_tmp = h-12;
            }

            var h_str = h_tmp+":00"+am_pm;
            var h_str_h = h_tmp+":30"+am_pm;
            hours.push(h_str);
            hours.push(h_str_h);
        }

        var html = '<select id="hf-sc-hours" name="hf-sc[scheduler][hours]">';
        $j.each(hours,function(i,v){
            html+='<option value="'+v+'"'+(hour==v?"selected='selected'":"")+'>'+v+'</options>';
        });

        html+='</select>';
        return html;
    }
    function getDays()
    {
        var days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        var html = '<select id="hf-sc-days" name="hf-sc[scheduler][days]">';
        $j.each(days,function(i,v){
            html+='<option value="'+i+'">'+v+'</option>';
        });
        html+='</select>';
        return html;
    }
    function getMonths()
    {
        var html = '<select id="hf-sc-months" name="hf-sc[scheduler][months]">';
        for(var i=1;i<=31;i++) {
            html += '<option value="' + i + '">' + i + '</option>';
        }
        html+='</select>';
        return html;
    }
    function isValue(val)
    {
        if(val)
        {
            return val;
        }
        return fals;
    }
</script>
<div class="wrap">
    <input type="hidden" name="_scheduler_nonce" value="<?php echo wp_create_nonce('hf-sc-scheduler')?>">
    <form class="hf-sc-edit-form">
        <table class="form-table">
            <tr>
                <th>
                    <label for="user-id">SoundCloud User ID</label>
                </th>
                <td>
                    <input type="text" name="hf-sc[scheduler][user-name]" id="user-name" value="<?php echo $obj->getSoundCloudUserId()?>" aria-required="true" required>
                </td>
            </tr>
            <tr>
                <th>
                    <label>Author of the import date</label>
                </th>
                <td>
                    <select name="hf-sc[scheduler][author]">
                        <?php $users = $obj->getUsers();?>
                        <?php foreach($users as $user):?>
                            <option value="<?php echo $user->id;?>"><?php echo $user->display_name;?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="frequency">Frequency</label>
                </th>
                <td>
                    <select class="hf-sc-frequency" id="frequency" data-scheduler-config-id="hf-sc-scheduler-config" name="hf-sc[scheduler][frequency]">
                        <?php
                        foreach ($cron_instance->getFrequency() as $f ) {
                                echo '<option value='.$f->id.' '.selected(empty($current_frequency)?'daily':$current_frequency,$f->id).'>'.$f->text.'</option>';
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr id="hf-sc-scheduler-config">

            </tr>
        </table>
    </form>
</div>

