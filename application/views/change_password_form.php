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
            <?php echo form_open('home/save_change_password') ?>
            <div class="span12">
            <div class="slate">
             
                <div class="page-header">
                    <div class="pull-right listing-buttons">
                    	<button class="btn btn-success">Save</button>
                   	 <a href="<?php echo base_url();?>index.php/home" class="btn btn-primary">Cancel</a>
                   </div>
                    <h2>Change Password  </h2>
                </div>
			
            <div class="content">
        <table  >
          <tbody>
          <tr>
            <td> New Password:</td>
            <td>              <input type="text" name="password" value="<?php echo '';?>"/>
             
                            </td>
          </tr>
          
          <tr>
            <td>Confirm Password:</td>
            <td>              <input type="text" name="confirm_password" value="<?php echo '';?>"/>
             
                            </td>
          </tr>
          
            
        </tbody></table>
        
          <br /><br /><br />
          </div>  
   </div>
           
			  </div>
				
				</form>
				</div>
			
			</div>
			
		</div>
<script language="javascript1.5">
// add new option value and correct its parent div id

$(document).ready(function(){});
</script>