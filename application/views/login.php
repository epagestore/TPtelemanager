<div class="main-area dashboard">
	
	<div class="container">

        <div class="slate" style="width: 400px; min-height: 300px; margin-top: 40px; margin-left: auto; margin-right: auto;">
            <div class="page-header">
              <h2> Please enter your login details.</h2>
            </div>
            <div class="content" style="min-height: 150px; overflow: hidden;">
            <?php if(isset($message)){echo "<span style='color:red;'>".$message."</span>";} ?>
            <?php echo form_open('','class=form-inline id="form"') ?>
                <table style="width: 100%;">
                  <tbody>
                  <tr>
                    <td>Username:<br>
                      <input type="text" name="username" value="" style="margin-top: 4px;">
                      <br>
                      <br>
                      Password:<br>
                      <input type="password" name="password" value="" style="margin-top: 4px;">
                                    <br>
                      <a href="http://localhost/oc/admin/index.php?route=common/forgotten">Forgotten Password</a>
                                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td style="text-align: right;"><a onclick="$('#form').submit();" class="btn">Login</a></td>
                  </tr>
                </tbody></table>
                      </form>
            </div>
          </div>

 	</div>
</div>