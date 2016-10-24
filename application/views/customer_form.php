<div class="main-area dashboard">
	
		<div class="container">
			
			<div class="alert alert-info hide">
				<a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Information</h4>
				This template shows how forms can be laid out for editing content.
			</div>
			<?php if(validation_errors()){?>
			<div class="alert alert-error">            	
				<a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error</h4>
				<?php echo validation_errors(); ?>
			</div>
			<?php }?>
			<div class="alert alert-success hide">
				<a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success</h4>
				Example of an success message alert.
			</div>
			
			<div class="alert alert-warning hide">
				<a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Warning</h4>
				Example of an warning message alert.
			</div>
			
			<div class="row">
             <?php echo form_open() ?>
				<div class="span12 ">
                	<div class="slate">
                	<div class="page-header">
						<div class="pull-right listing-buttons">
                            <button class="btn btn-success">Save</button>
                            <a href="<?php echo base_url();?>index.php/customer" class="btn btn-primary">Cancel</a>
                		</div>
						<h2>Customer </h2>
					</div>
   					<div class="content">
                    
                    
                    
                    
                    </div>
            </div>  
        </div>
	</form>
</div>
			
</div>
	
</div>




<script language="javascript1.5">
$("#add_option").click(function(){
	if($("#option_data_div").children().length>0)
		$new_id=parseInt($("#option_data_div").children().last().attr('id').match(/\d+/))+1;
	else
		$new_id=0;
		$option_id=$(this).siblings('#options').val();
		$id=$new_id;
		$.ajax({
					url: '<?php echo base_url();?>index.php/category/getdata/'+$option_id,
					dataType: 'json',
					success: function(json) {
						html='<select id="category_values_toadd" style="display:none">';
					$.map(json, function(item) {
						html+='<option value="'+item.option_value_id+'">'+item.name+'</option>';
						
					})
					html+='</select>';
					table='<table id="option_values" class="list orders-table table"><thead><tr><td> Option Value Name:</td><td class="value">Sort Order:</td><td class="actions">Action :</td></tr></thead><tfoot></tfoot></table>';
					$("#option_data_div").children('.active').removeClass('active');
					$("#option_data_div").append('<div class="tab-pane active nav-right" id="option_data_'+$new_id+'"> <label class="control-label" for="select">Required:</label>  <select name="required[]" ><option  value="0" >No</option><option   value="1">Yes</option></select> <label class="control-label" for="input0">Sort Order:</label>  <input type="text" name="option_order[]" value=""/><br /><input type="hidden" name="category_option_id[]" value=""/><input type="hidden" name="option_id[]" value="'+$("#add_option").siblings('#options').val()+'"/>'+html+table+' <input type="button" class="btn btn-primary option-add" value="Add Values" name="add_value[]" id="add_value" onclick="addvalue($(this))" /></div>');
					$("#options_div").find('.active').removeAttr('class','active');
					$("#options_div").children().last().before('<li class="active"><a href="#option_data_'+$new_id+'" data-toggle="tab">'+$("#add_option").siblings('#options').children(':selected').text()+'<i class="icon-minus-sign" onclick="deleteoption($(this))"></i><input type="hidden" name="option_name[]" value="'+$("#add_option").siblings('#options').children(':selected').text()+'" ></a> </li>');
					$("#options_div").find('.active').find('a').click();
					}
			  });
	 	
});
function addvalue($this){
	if($this.siblings("#option_values").children('tbody').length>0)
		$new_id=parseInt($this.siblings("#option_values").children('tbody').last().attr("id"))+1;
	else
		$new_id=0;
	$this.siblings("#option_values").find("tfoot").before('<tbody id="'+$new_id+'"><tr><td></td></tr></tbody>');
	$obj=$this.siblings("#category_values_toadd");
	$new_tbody=$this.siblings("#option_values").children("#"+$new_id);
	$new_tr=$this.siblings("#option_values").children("#"+$new_id).find('tr');
	$new_td=$this.siblings("#option_values").children("#"+$new_id).find('tr td');
	$cat_id=$new_tbody.parent().parent().attr('id').match(/\d+/);
	$obj.clone().appendTo($new_td).attr('name','category_values['+$cat_id+'][]').css('display','').attr('id','category_value');
	$new_tr.append('  <td class="value">1</td> <td class="actions"><input class="btn btn-small btn-danger" type="button" value="Remove" name="delete" onclick="deleteoption_value($(this))"/></td>');
}
function deleteoption_value($this){
	
	
	$id=$this.parents('tbody').attr('id');
	$this.parents('tbody').siblings().each(function(){
		if( parseInt($(this).attr('id')) > parseInt($id))
		{
			$(this).attr('id',parseInt($(this).attr('id'))-1);			
		}
	});
	
	$this.parents('tbody').remove();
	
}
function deleteoption($this){
		
		
		$('#removeItem').modal('toggle');
		$('#removeItem .btn-danger').click(function () {
		
			$id=parseInt($this.parent().attr('href').match(/\d+/));
			
			$this.parent().parent().siblings().each(function(){
				if($(this).children('a').attr('href')){
					if( parseInt($(this).children('a').attr('href').match(/\d+/)) > $id)
					{
						href=$(this).children('a').attr('href');
						$(this).children('a').attr('href','#option_data_'+(parseInt(href.match(/\d+/))-1))
					}
				}
			});
			$this.parent().parent().siblings().first().children('a').click();
			$this.parent().parent().remove();
			
			$("#option_data_div").children($this.parent().attr('href')).remove();
			$("#option_data_div").children().each(function(){
				if( parseInt($(this).attr('id').match(/\d+/)) > parseInt($id))
				{
					$(this).children('#option_values').find('select[name="category_values\\['+parseInt($(this).attr('id').match(/\d+/))+'\\]\\[\\]"]').attr('name','category_values['+(parseInt($(this).attr('id').match(/\d+/))-1)+'][]');
					$(this).children('#option_values').find('input[name="category_option_value_id\\['+parseInt($(this).attr('id').match(/\d+/))+'\\]\\[\\]"]').attr('name','category_option_value_id['+(parseInt($(this).attr('id').match(/\d+/))-1)+'][]');
					$(this).attr('id','option_data_'+(parseInt($(this).attr('id').match(/\d+/))-1));			
				}
			});
			$('#removeItem').modal('hide');
		});
}
$(document).ready(function(){
	
});

</script>