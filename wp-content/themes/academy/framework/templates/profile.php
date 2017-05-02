<style>
    .resource-box{
        overflow: auto;
        width: 300px;
        height: 250px;
        border: 1px solid #000;
        position: relative;
    }
    .resource-box .loader{
        position: absolute;
        left: 50%;
        top: 50%;
        margin: -16px 0 0 -16px;
        border-radius: 10px;
    }
    .user-resources td{
        vertical-align: top;
    }
    #assign,#remove{
        margin: 10px 0 0;
    }
</style>
<h3>User resources</h3>
<table class="user-resources">
    <tr>
        <td>
            <span>Resource Categories:</span>
            <div id="resource-cats" class="resource-box">
                <?php $taxonomies = get_terms(array('resources'),array('hide_empty' => false,'parent' => 0,'orderby' => 'date')); ?>
                <?php if(!empty($taxonomies)){ ?>
                    <ol>
                        <?php foreach($taxonomies as $tax){ ?>
                            <li><label><input type="radio" name="res-cat" value="<?php echo $tax->term_id ?>" /> <?php echo $tax->name ?></label></li>
                        <?php } ?>
                    </ol>
                <?php } ?>
            </div>
        </td>
        <td>
            <span>Resources:</span>
            <div id="resources" class="resource-box"></div>
            <input type="button" class="button-primary" id="assign" value="Assign" />
        </td>
        <td>
            <span>Current User Resources:</span>
            <div id="current-resources" class="resource-box">
                <?php $user_resources = get_user_meta(self::$user->ID,'user_resources',true); ?>
                <ol>
                    <?php if(!empty($user_resources)){ ?>
                        <?php foreach($user_resources as $res){ ?>
                            <?php $resource = get_post($res); ?>
                            <li><input type="checkbox" name="res" value="<?php echo $resource->ID ?>" /> <a href="post.php?post=<?php echo $resource->ID ?>&action=edit" target="_blank"><?php echo $resource->post_title ?></a></li>
                        <?php } ?>
                    <?php } ?>
                </ol>
            </div>
            <input type="button" class="button-primary" id="remove" value="Remove" />
        </td>
    </tr>
</table>
<script>
(function( $ ) {
$(function() {
    
    $('#resource-cats input').change(function(){
        $('#resources').append('<img class="loader" src="<?php echo THEME_URI ?>images/loader.gif" />');
        var data = {
            action: 'resourceAjax',
            method: 'get_resources',
            cat_id: $(this).val()
        }
        
        $.post(ajaxurl,data,function(r){
            $('#resources').empty();
            
            if(r.status == 'ok'){
                if(r.data.length){
                    var html = '<ol>';
                    for(var i in r.data){
                        html += '<li><label><input type="checkbox" name="res" value="'+r.data[i].ID+'" /> '+r.data[i].post_title+'</label></li>';
                    }
                    html += '</ol>';
                    
                    $('#resources').html(html);
                }else{
                    $('#resources').html('no resources');
                }
            }
            
        },'json');
    });
    
    $('#assign').click(function(){
        $('#current-resources').append('<img class="loader" src="<?php echo THEME_URI ?>images/loader.gif" />');
        
        var resources = [];
        $('#resources input:checked').each(function(){
            resources.push($(this).val());
        });
        
        var data = {
            action: 'resourceAjax',
            method: 'add',
            user_id: $('#user_id').val(),
            resources: resources
        }
        
        $.post(ajaxurl,data,function(r){
            $('#current-resources').empty();
            
            if(r.status == 'ok' && r.data.length){
                var html = '<ol>';
                for(var i in r.data){
                    html += '<li><input type="checkbox" name="res" value="'+r.data[i].ID+'" /> <a href="post.php?post='+r.data[i].ID+'&action=edit" target="_blank">'+r.data[i].post_title+'</a></li>';
                }
                html += '</ol>';
                
                $('#current-resources').html(html);
            }
        },'json');
    });
    
    $('#remove').click(function(){
        $('#current-resources').append('<img class="loader" src="<?php echo THEME_URI ?>images/loader.gif" />');
        
        var resources = [];
        $('#current-resources input:checked').each(function(){
            resources.push($(this).val());
        });
        
        var data = {
            action: 'resourceAjax',
            method: 'remove',
            user_id: $('#user_id').val(),
            resources: resources
        }
        
        $.post(ajaxurl,data,function(r){
            $('#current-resources').empty();
            
            if(r.status == 'ok' && r.data.length){
                var html = '<ol>';
                for(var i in r.data){
                    html += '<li><input type="checkbox" name="res" value="'+r.data[i].ID+'" /> <a href="post.php?post='+r.data[i].ID+'&action=edit" target="_blank">'+r.data[i].post_title+'</a></li>';
                }
                html += '</ol>';
                
                $('#current-resources').html(html);
            }
        },'json');
    });
});
})(jQuery);
</script>