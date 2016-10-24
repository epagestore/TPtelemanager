<link href="<?php echo base_url();?>css/style.css" rel="stylesheet">
<div class="main-area dashboard">

	<div class="container">
		<?php if( validation_errors()){ ?>
            <div class="alert alert-error">
                <a class="close" data-dismiss="alert" href="#">x</a>
                <h4 class="alert-heading">Error</h4>
                <?php echo validation_errors(); ?>
            </div>
		<?php }?>
			            		
			<div class="row">
            <?php echo form_open('','class="form-horizontal" id="information-form" enctype="multipart/form-data" ') ?>
            <div class="span12">
            <div class="slate">
             
                <div class="page-header">
                    <div class="pull-right listing-buttons">
                    	<button class="btn btn-success" onclick="$('#form').submit();">Save</button>
                   	 <a href="<?php echo base_url();?>index.php/information" class="btn btn-primary">Cancel</a>
                   </div>
                    <h2>Information </h2>
                </div>

 <div class="content">
<script src="<?php echo base_url();?>js/library/bootstrap-fileupload.js"></script>


<div class="singleBox" id="BasicInfo">

          <div class="singleBoxContent">
            
              <div class="control-group">

				     <label class="control-label1" for="select01"> * Title : </label> 
                
	                  <input type="text" name="title"  value="<?php echo $title?>" />
    	              <input type="hidden" name="information_id" value="<?php echo $information_id;?>" />
				
               </div>
            
               
              <div class="control-group">
                <label class="control-label1" for="select01"> * Type : </label> 
            <select name="information_type">
                	<option value="buy" <?php if($information_type=='buy') echo "selected"; ?>>Buy</option>
                    <option value="sell" <?php if($information_type=='sell') echo "selected"; ?>>Sell</option>
                	<option value="community" <?php if($information_type=='community') echo "selected"; ?>>Community</option>
                    <option value="help" <?php if($information_type=='help') echo "selected"; ?>>Help
</option>

                </select>
                            
                </div>            
            
            
            <?php
			
			$basic_checked=""; 
			$standard_checked="";
			$premium_checked="";
			
			if($membership_type != '')
			 {
				if(in_array('basic_seller',$membership_type)){       
						$basic_checked="CHECKED";
				} else{ 
						$basic_checked=""; }
						
				if(in_array('standard_seller',$membership_type)){       
						$standard_checked="CHECKED";
				} else{ 
						$standard_checked=""; }
						
				if(in_array('premium_seller',$membership_type)){       
						$premium_checked="CHECKED";
				} else{ 
						$premium_checked=""; }					
			 } ?>
            
                         
              <div class="control-group">  
                <label class="control-label1" for="select01"> * Available to : </label>                                     
                    Basic Sellers <input type="checkbox" name="membership_type[]" value="basic_seller" <?php echo $basic_checked; ?>/>  &nbsp;&nbsp;Standard Sellers <input type="checkbox" name="membership_type[]" value="standard_seller" <?php echo $standard_checked; ?>/>&nbsp;&nbsp;Premium Sellers <input type="checkbox" name="membership_type[]" value="premium_seller" <?php echo $premium_checked; ?>/>                    

            </div>
            
              <div class="control-group">

                <label class="control-label1" for="select01"> * Description : </label> 
               	<textarea name="message"><?php echo $description; ?></textarea>
                 
            </div>
            
         
            
            
            <div class="control-group">

                <label class="control-label1" for="select01"> * Status : </label> 
                
					<select name="status" id="status" style="width:100px">
                    <option <?php if($status=='1')echo 'selected'?> value="1">Enabled</option>
                    <option <?php if($status=='2')echo 'selected'?> value="2">Disabled</option>
                  </select>
             </div>

<br />
<hr />

<hr />




                	</div>
                </div>
			</div>
            </form>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url();?>js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
CKEDITOR.replace('message', {
});

function formsubmit(){
	$('textarea[name="message"]').val(CKEDITOR.instances.message.getData());
	$("#information-form").submit();
}
function loadCat($this){}
$("#submit").click(function(){
		$("#select_categories").css('display','none');
		$("#product_details_div").css('display','block');
		$("#categoryIDs").val($("#categoires_div").children('select').last().val());
		$("#supplier_ids").val($("#supplier_id").val());
		loadProductDetails();
});

function addOptionValue() {}
$(document).ready(function(){});
</script>