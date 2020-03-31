<?php
    defined('BASEPATH') OR exit("ooops, we are sorry. It's not you, it's us! Please use the back navigation button to go back.");

    ////////////////////////////////////////////////////////////////////////////////////////
    // LOAD ASSETS
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->helper( 'url' );
    $assets = base_url() . "assets/";
    $cssbase = base_url() . "assets/css/";
    $jsbase = base_url() . "assets/js/";

    $base = base_url() . index_page();
    ////////////////////////////////////////////////////////////////////////////////////////


    ////////////////////////////////////////////////////////////////////////////////////////
    // HTML OPEN TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/headers/html/html_tag_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // HEAD OPEN TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/headers/html/header_head_tag_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // HEAD CSS, LINKS, TITLE, META TAG
    ////////////////////////////////////////////////////////////////////////////////////////
	$this->load->view('player/essentials/headers/css/header_head_css_links');
	$this->load->view('player/pages/myaccount/css/tel_input');

    ////////////////////////////////////////////////////////////////////////////////////////
    // HEAD CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/headers/html/header_head_tag_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY OPEN TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/body_tag_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // <MAIN NAV OPEN TAG>
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/main_nav_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // MAIN NAV
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/main_nav_restricted');

    ////////////////////////////////////////////////////////////////////////////////////////
    // </MAIN NAV CLOSE TAG>
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/main_nav_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // MAIN CONTENT OPEN TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    //Enable this for game look
    //$this->load->view('player/essentials/body/body_main_content_start');
    //Enable this for vanilla look
    $this->load->view('player/essentials/body/body_main_vanilla_content_start');
    

?>

    <!-- main Content Goes Here -->
    <div class="row">
        <div class="col-md-12">
            <!-- Multi step form --> 
            <section class="multi_step_form">  
                <form id="msform" method="POST" action="<?php echo $base . '/authorization/getsignupdetails'; ?>" enctype="multipart/form-data" class="signup-needs-validation" novalidate> 
                    <!-- Tittle -->
                    <div class="tittle">
                    <h2 class="text-uppercase">Create A Free Account</h2>
                    <p>In order to use this service, you have to complete this signup process</p>
                    </div>
                    <!-- progressbar -->
                    <ul id="progressbar">
						<li class="active">About You</li>
						<li>Contact Info</li>
						<li>Upload Documents</li> 
						<li>Account</li>
                    </ul>
                    <!-- fieldsets -->
					<!-- About You -->
                    <fieldset>
						<?php
							$form_validation_error = $this->session->flashdata('form_validation_error');
							if(strlen($form_validation_error) > 0){
								echo '<div style="width:100%; margin:auto;" class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><center>';
								echo $form_validation_error;
								echo '</center></div><br>';
							}
						?>

						<?php echo validation_errors(); ?>
						<div class="form-group">
							<div class="btn-group btn-group-lg btn-group-toggle" data-toggle="buttons">
								<label class="btn btn-secondary active">
									<input type="radio" name="title" id="titleMr" value="Mr" autocomplete="off" <?php if(empty(set_value('title'))){echo "checked";}else if(form_error('title') == "Mr"){echo "checked";} ?> required> Mr
								</label>
								<label class="btn btn-secondary">
									<input type="radio" name="title" id="titleMrs" value="Mrs" autocomplete="off" <?php if(set_value('title') == "Mrs"){echo "checked";} ?> required> Mrs
								</label>
								<label class="btn btn-secondary">
									<input type="radio" name="title" id="titleMs" value="Ms" autocomplete="off" <?php if(set_value('title') == "Ms"){echo "checked";} ?> required> Ms
								</label>
								<label class="btn btn-secondary">
									<input type="radio" name="title" id="titleMiss" value="Miss" autocomplete="off" <?php if(set_value('title') == "Miss"){echo "checked";} ?> required> Miss
								</label>
								<div class="valid-feedback">
									Looks good!
								</div>
								<div class="invalid-feedback">
									Please enter your First Name
								</div>
							</div>
							<?php echo form_error('title'); ?>
						</div>

						<div class="form-group"> 
							<input type="text" value="<?php echo set_value('firstName'); ?>" name="firstName" id="firstName" class="form-control form-control-lg" placeholder="First name" required>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please enter your First Name
							</div>
							<?php echo form_error('firstName'); ?>
						</div>

						<div class="form-group"> 
							<input type="text" value="<?php echo set_value('lastName'); ?>" name="lastName" id="lastName" class="form-control form-control-lg" placeholder="Last name" required>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please enter your Last Name
							</div>
							<?php echo form_error('lastName'); ?>
						</div>

						<div class="form-group">
							<p style="text-align:left;">Date of Birth</p>
							<div class="form-row">
								<div class="col-md-3">
									<select class="form-control form-control-lg" name="dobDay" id="dobDay" required>
										<?php if(empty(set_value('dobDay'))){ ?>
											<option disabled selected value="">Day</option>
										<?php }else{ ?>
											<option value="<?php echo set_value('dobDay'); ?>" selected><?php echo set_value('dobDay'); ?></option>
										<?php } ?>
										
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
										<option value="26">26</option>
										<option value="27">27</option>
										<option value="28">28</option>
										<option value="29">29</option>
										<option value="30">30</option>
										<option value="31">31</option>
									</select>
									<div class="valid-feedback">
										Looks good!
									</div>
									<div class="invalid-feedback">
										Please select a day
									</div>
									<?php echo form_error('dobDay'); ?>
								</div>
								<div class="col-md-3">
									<select class="form-control form-control-lg" name="dobMonth" id="dobMonth" required>
										<?php if(empty(set_value('dobDay'))){ ?>
											<option disabled selected value="">Month</option>
										<?php }else{ ?>
											<option value="<?php echo set_value('dobMonth'); ?>" selected><?php echo set_value('dobMonth'); ?></option>
										<?php } ?>
										
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">August</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">November</option>
										<option value="12">December</option>
									</select>
									<div class="valid-feedback">
										Looks good!
									</div>
									<div class="invalid-feedback">
										Please select a month
									</div>
									<?php echo form_error('dobMonth'); ?>
								</div>
								<div class="col-md-3">
									<?php
										$year = date('Y') - 18;
										$year_limit = 0; //Generate last 60 years
									?>
									<select class="form-control form-control-lg" name="dobYear" id="dobYear" required>
										<?php if(empty(set_value('dobYear'))){ ?>
											<option disabled selected value="">Year</option>
										<?php }else{ ?>
											<option value="<?php echo set_value('dobYear'); ?>" selected><?php echo set_value('dobYear'); ?></option>
										<?php } ?>

										
										<?php
											while($year_limit != 60){
												echo "<option value='".$year."'>".$year."</option>";
												$year -= 1;
												$year_limit ++;
											}
										?>
										
									</select>
									<div class="valid-feedback">
										Looks good!
									</div>
									<div class="invalid-feedback">
										Please select a year
									</div>
									<?php echo form_error('dobYear'); ?>
								</div>
								<div class="col-md-3">
									<p class="underage_tag">18+</p>
								</div>
							</div>
						</div>

						<div class="form-group"> 
							<input type="email" value="<?php echo set_value('email'); ?>" name="email" id="email" class="form-control form-control-lg" placeholder="Email" required>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please enter an email
							</div>
							<?php echo form_error('email'); ?>
						</div>
						 
						<button type="button" id="btnContinueToContactInfo" class="next btn btn-success btn-lg btn-block">Continue</button>  
					</fieldset>

					<!-- Contact Info -->
					<fieldset>
						<div class="form-group"> 
							<select class="form-control form-control-lg country" name="country_id" id="country_id" required>
								<option disabled selected value="">Select a country</option>
								

								<?php if($countries != false){ ?>
									<?php foreach($countries as $key => $country) { ?>
										<option value="<?php echo $country->id; ?>"
											<?php if(set_value('country') == $country->id){echo 'selected';} ?>>
											<?php echo $country->name; ?>
										</option>
									<?php } ?>
								<?php } ?>
							</select>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Country required.
							</div>
							<?php echo form_error('country'); ?>
						</div>


						<div class="form-group"> 
							<select class="form-control form-control-lg state" name="state_id" id="state_id">
								<?php if(empty(set_value('state'))){ ?>
									<option disabled selected value="">Select a state</option>
								<?php }else{ ?>
									<option value="<?php echo set_value('state'); ?>" selected><?php echo set_value('state'); ?></option>
								<?php } ?>
							</select>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								State required.
							</div>
							<?php echo form_error('state'); ?>
						</div>

						<div class="form-group"> 
							<select class="form-control form-control-lg city" name="city_id" id="city_id" required>
								<?php if(empty(set_value('city'))){ ?>
									<option disabled selected value="">Select a city</option>
								<?php }else{ ?>
									<option value="<?php echo set_value('city'); ?>" selected><?php echo set_value('city'); ?></option>
								<?php } ?>
							</select>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								City required.
							</div>
							<?php echo form_error('city'); ?>
						</div>

						<div class="form-group"> 
							<input type="text" value="<?php echo set_value('addressLineOne'); ?>" name="addressLineOne" id="addressLineOne" class="form-control form-control-lg" placeholder="Address Line 1" required>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please enter a Address Line 1.
							</div>
							<?php echo form_error('addressLineOne'); ?>
						</div>
						
						<div class="form-group"> 
							<input type="text" value="<?php echo set_value('addressLineTwo'); ?>" name="addressLineTwo" id="addressLineTwo" class="form-control form-control-lg" placeholder="Address Line 2">
							<!-- <div class="valid-feedback">
								Looks good!
							</div> -->
							<div class="invalid-feedback">
								Please enter a Address Line 2.
							</div>
							<?php //echo form_error('addressLineTwo'); ?>
						</div>

						<div class="form-group"> 
							<input type="text" value="<?php echo set_value('townCity'); ?>" name="townCity" id="townCity" class="form-control form-control-lg" placeholder="Town / City" required>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please enter a Town / City.
							</div>
							<?php echo form_error('townCity'); ?>
						</div>


						<div class="form-group"> 
							<input type="text" value="<?php echo set_value('postCode'); ?>" name="postCode" id="postCode" class="form-control form-control-lg" placeholder=" Post Code / Zip Code" required>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please enter a post code.
							</div>
							<?php echo form_error('postCode'); ?>
						</div>

						<div class="form-group">
							<input type="tel" value="<?php echo set_value('phone'); ?>" name="phone" id="phone" class="form-control" required>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please enter a phone number.
							</div>
							<?php echo form_error('phone'); ?>
						</div> 
						
						<button type="button" class="action-button previous previous_button">Back</button>
						<button type="button" class="next action-button">Continue</button>
					</fieldset>
					
					<!-- Upload Documents -->
                    <fieldset>
						<h3>Bit more information needed</h3>
						<h6>Please upload any of these documents to verify your Identity.</h6>
						
						<div class="passport">
							<h4>Driving License or Passport <br>Utility bill &amp; Bank statement</h4> 
						</div>
						<div class="alert alert-info">
							<small class="text-muted"><strong>Supported file types</strong> pdf | doc| jpg | png | jpeg</small>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="custom-file">
									<input type="file" name="drivingLicenseOrPassportFile" class="custom-file-input" id="drivingLicenseOrPassportFile" accept=".pdf,.doc,.jpg,.png,.jpeg" required>
									<label class="custom-file-label" for="drivingLicenseOrPassportFile">Driving License / Passport</label>
									<div class="valid-feedback">
										Looks good!
									</div>
									<div class="invalid-feedback">
										Please enter a username.
									</div>
								</div>
							</div>
							<?php echo form_error('drivingLicenseOrPassportFile'); ?>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="custom-file">
									<input type="file" name="utilityBillFile" class="custom-file-input" id="utilityBillFile" accept=".pdf,.doc,.jpg,.png,.jpeg" required>
									<label class="custom-file-label" for="utilityBillFile">Utility bill</label>
									<div class="valid-feedback">
										Looks good!
									</div>
									<div class="invalid-feedback">
										Please enter a username.
									</div>
								</div>
							</div>
							<?php echo form_error('utilityBillFile'); ?>
							<div class="input-group">
								<div class="custom-file">
									<input type="file" name="bankStatementFile" class="custom-file-input" id="bankStatementFile" accept=".pdf,.doc,.jpg,.png,.jpeg" required>
									<label class="custom-file-label" for="bankStatementFile">Bank statement</label>
									<div class="valid-feedback">
										Looks good!
									</div>
									<div class="invalid-feedback">
										Please enter a username.
									</div>
								</div>
							</div>
							<?php echo form_error('bankStatementFile'); ?>
						</div>

						<div class="form-group">
							<div class="alert alert-info" role="alert">
								(Bank statement &amp; Utility Bill Must be within the last 3 months)
							</div>
						</div>

						<button type="button" class="action-button previous previous_button">Back</button>
						<button type="button" class="next action-button">Continue</button>  
					</fieldset>
					
					<!-- Account information -->
                    <fieldset>
						<h3>Account</h3>
						<h6><small>Please include alphabets, numbers and special characters for a stronger password.</small></h6> 
						<div class="form-group"> 
							<input type="text" value="<?php echo set_value('username'); ?>" name="username" id="username" class="form-control form-control-lg" placeholder="Username" required>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please enter a username.
							</div>
							<?php echo form_error('username'); ?>
						</div>

						<div class="form-group"> 
							<input type="password" name="password" id="password"  class="form-control form-control-lg" placeholder="Password" required>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please enter a username.
							</div>
							<?php echo form_error('password'); ?>
						</div>

						<div class="form-group">
							<input type="password" name="confirmPassword" id="confirmPassword" class="form-control form-control-lg" placeholder="Password" required>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please enter a username.
							</div>
							<?php echo form_error('confirmPassword'); ?>
						</div>

						<!--
						<h3>Add Credits</h3>
						<h6><small>Please include alphabets, numbers and special characters for a stronger password.</small></h6>

						<div class="form-group row">
                            <div class="col-md-6">
                                <label for="amount"><strong>Amount*</strong></label>
								<input type="text" name="moneyAmount" id="moneyAmount" value="<?php echo set_value('moneyAmount'); ?>" class="form-control" placeholder="Amount" required>
								<div class="valid-feedback">
									Looks good!
								</div>
								<div class="invalid-feedback">
									Please enter your Last Name
								</div>
								<?php echo form_error('moneyAmount'); ?>
                            </div>
                            <div class="col-md-6">
                                <label for=""><strong>Currency*</strong></label>
                                <select class="form-control" name="amountType" id="amountType" required>
									<?php if(empty(set_value('amountType'))){ ?>
										<option disabled selected value="">Select currency</option>
									<?php }else{ ?>
										<option value="<?php echo set_value('amountType'); ?>" selected><?php echo set_value('amountType'); ?></option>
									<?php } ?>
                                    <option value="Pound">Pound Sterling</option>
                                    <option value="Euro">Euro</option>
                                    <option value="Dollar">Dollar</option>
								</select>
								<div class="valid-feedback">
									Looks good!
								</div>
								<div class="invalid-feedback">
									Please enter your Last Name
								</div>
								<?php echo form_error('amountType'); ?>
                            </div>
                        </div>
                    
                    

                        <div class="form-group row">
                            <div class="col-md-6">
								<input type="text" name="creditAmount" id="creditAmount" value="<?php echo set_value('creditAmount'); ?>" class="form-control" placeholder="Converted Amount" readonly="readonly" required>
								<div class="valid-feedback">
									Looks good!
								</div>
								<div class="invalid-feedback">
									Please enter your Last Name
								</div>
								<?php echo form_error('creditAmount'); ?>
                            </div>
                            <div class="col-md-6">
								
								<input type="text" class="form-control" placeholder="Credits" value="Credits" disabled>
                            </div>
                        </div>
                        -->
						
						<style>
							/* total width */
							.terms::-webkit-scrollbar {
								background-color:#fff;
								width:16px
							}

							/* background of the scrollbar except button or resizer */
							.terms::-webkit-scrollbar-track {
								background-color:#fff
							}
							.terms::-webkit-scrollbar-track:hover {
								background-color:#f4f4f4
							}

							/* scrollbar itself */
							.terms::-webkit-scrollbar-thumb {
								background-color:#babac0;
								border-radius:16px;
								border:5px solid #fff
							}
							.terms::-webkit-scrollbar-thumb:hover {
								background-color:#a0a0a5;
								border:4px solid #f4f4f4
							}

							/* set button(top and bottom of the scrollbar) */
							.terms::-webkit-scrollbar-button {display:none}

							.terms {
								height:150px;
								overflow-y:auto;
								margin-top:10px;
								border:1px solid #cccccc;
								padding:3px;
								text-transform:uppercase;
								margin-top:20px;
								border-radius:5px;
							}
							.terms p {
								font-size:0.8rem;
							}
						</style>
						<div class="form-group text-left">
							<div class="terms">
								<h3>TERMS OF SERVICE</h3>
								<p><?php echo $general_settings[0]->terms_of_use; ?></p>
							</div><br>
							<div class="form-check">
								<input name="agree" id="agree" class="form-check-input" type="checkbox" value="1" id="invalidCheck" <?php if(!empty(set_value('creditAmount'))){echo "checked";} ?> required>
								<label class="form-check-label" for="invalidCheck">
									Agree to terms and conditions
								</label>
								<div class="invalid-feedback">
									You must agree before submitting.
								</div>
							</div>
								<?php echo form_error('agree'); ?>
						</div><br>

						<button type="button" class="action-button previous previous_button">Back</button> 
						<button type="submit" href="#" class="action-button">Complete Signup</button>
						
                    </fieldset> 
				</form>
				
            </section> 
            <!-- End Multi step form -->
        </div>
	</div>
	

	<!-- Error Modal -->
	<!-- Modal -->
	<div class="modal fade" id="formErroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content" style="border:1px solid red;">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Validation Error</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				You have entered invalid data, please use the <span class="badge badge-secondary">Previous</span> or <span class="badge badge-secondary">Next</span> button to review the information entered!
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary">Okay</button>
			</div>
			</div>
		</div>
	</div>


<?php
    ////////////////////////////////////////////////////////////////////////////////////////
    // FOOTER CONTENT
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/footers/html/footer_content');

    ////////////////////////////////////////////////////////////////////////////////////////
    // MAIN CONTENT CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
	$this->load->view('player/essentials/body/body_main_content_end');
	
	////////////////////////////////////////////////////////////////////////////////////////
    // Load JavaScript, Jquery File here
	////////////////////////////////////////////////////////////////////////////////////////
	$this->load->view('player/pages/myaccount/js/multi_step_js');
	$this->load->view('player/pages/myaccount/js/signup_validation_js');
	$this->load->view('api/change_state_city_on_country_selection');

    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/body_tag_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/footers/html/html_tag_close');
?>

