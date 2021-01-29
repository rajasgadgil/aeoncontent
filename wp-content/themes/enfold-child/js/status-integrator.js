jQuery(document).ready(function(){
    jQuery("select#post_status option").remove();
    jQuery("select#post_status").append("<option value=\"draft\">Draft</option><option value=\"ready-for-review\">Ready for Review</option>");
});