
$j = jQuery.noConflict();
$j(document).ready(function()
    {
        $j(".hf-delete-button").click(function(){
            var elem_name =$j(this).attr("data-element-name");
            return confirm("Are you sure you want to delete this "+elem_name+"?");
        });
    }
);

function ManagePanelBtn(id)
{
    $j(id).on('click',function(){

        var panelId = $j(this).attr("data-manage-panel-id");
        var panel = $j('#'+panelId);

        if(panel.is(":visible"))
        {
            $j(this).text("Show");
            panel.hide(500);
        }else
        {
            $j(this).text("Hide");
            panel.show(500);
        }
    });
}
function ManageDependentFields(id)
{
    var dependent = $j(id).attr("data-dependent-fields");
    var fields_ids_str = dependent.replace(/\|/g,',#');
    var fields = $j('#'+fields_ids_str);
console.log(dependent);
    $j(id).on('change',function(){
        var _self = this;
        if (fields.length > 1) {
            $j.each(fields, function (i, element) {
                $j(element).val($j(_self).val());
            });
        }
        else
        {
            fields.val($j(this).val());
        }
    });
}