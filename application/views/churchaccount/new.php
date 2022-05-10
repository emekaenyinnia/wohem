<section class="content">
    <!-- Page content-->
    <div class="container-fluid">
        <div class="block-header">
            <h2>Add New Church Account</h2>
        </div>


            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                
                        <div class="body">
                          <div class="card-inner">
                          <form method="POST" action="<?php echo base_url(); ?>savenewchurchaccount"  style="margin-top:30px;">
                          
                            <div class="input-group addon-line" style="margin-top:20px;">

                                <div class="form-line">
                                    <input type="text" class="form-control" name="account_name" placeholder="Account Name" required="" autofocus="">
                                </div>
                            </div>

                            <div class="input-group addon-line" style="margin-top:20px;">
                            <!-- <div class="form-line">
                                    <input type="text" class="form-control" name="account_bank" placeholder="Bank" required="" autofocus="">
                                </div>
                            </div> -->
                            <select type="text" name="account_bank" class="form-control " id="bank" required="">
                                <option  disabled="disabled">Choose Bank Name </option>
                                <option value="access">Access Bank</option>
                                <option value="citibank">Citibank</option>
                                <option value="diamond">Diamond Bank</option>
                                <option value="ecobank">Ecobank</option>
                                <option value="fidelity">Fidelity Bank</option>
                                <option value="fcmb">First City Monument Bank (FCMB)</option>
                                <option value="fsdh">FSDH Merchant Bank</option>
                                <option value="gtb">Guarantee Trust Bank (GTB)</option>
                                <option value="heritage">Heritage Bank</option>
                                <option value="Keystone">Keystone Bank</option>
                                <option value="rand">Rand Merchant Bank</option>
                                <option value="skye">Skye Bank</option>
                                <option value="stanbic">Stanbic IBTC Bank</option>
                                <option value="standard">Standard Chartered Bank</option>
                                <option value="sterling">Sterling Bank</option>
                                <option value="suntrust">Suntrust Bank</option>
                                <option value="union">Union Bank</option>
                                <option value="uba">United Bank for Africa (UBA)</option>
                                <option value="unity">Unity Bank</option>
                                <option value="wema">Wema Bank</option>
                                <option value="zenith">Zenith Bank</option>
                                </select>
                                </div>
                            </div>

                            <div class="input-group addon-line" style="margin-top:20px;">
                            <div class="form-line">
              
                                    <input type="text" class="form-control" name="account_number" placeholder="Account Number" required="" autofocus="">
                                </div>
                            </div>
                            </div>

                             <?php $this->load->helper('form'); ?>
                             <div class="row">
                                 <div class="col-md-12">
                                     <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                                 </div>
                             </div>
                             <?php
                          $this->load->helper('form');
                          $error = $this->session->flashdata('error');
                          if($error)
                          {
                              ?>
                              <div class="alert alert-danger alert-dismissable">
                                  <button id="sel_userfail" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                  <?php echo $error; ?>
                              </div>
                          <?php }
                          $success = $this->session->flashdata('success');
                          if($success)
                          {
                              ?>
                              <div class="alert alert-success alert-dismissable">
                                  <button id='sel_usersuccess' type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                  <?php echo $success; ?>
                              </div>
                          <?php } ?>
                             <div class="input-group addon-line" style="margin-top:10px;">
                            <div class="box-footer text-center " style="margin-bottom: 20px;">
                               <button class="btn btn-primary waves-effect" type="submit">SAVE ACCOUNT DETAILS </button>
                            </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                </div>
    </div>
</section