<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Add New Admin User</h2>
        </div>
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">

                        <div class="body">
                          <div class="card-inner">
                          <form id="log_in" method="POST" action="<?php echo base_url(); ?>savenewadmin">
                            <div class="input-group addon-line">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="name" placeholder="Full Name" required="" autofocus="">
                                </div>
                            </div>
                              <div class="input-group addon-line">
                                  <span class="input-group-addon">
                                      <i class="material-icons">email</i>
                                  </span>
                                  <div class="form-line">
                                      <input type="email" class="form-control" name="email" placeholder="Email Address" required="" autofocus="">
                                  </div>
                              </div>
                              <div class="input-group addon-line">
                                  <span class="input-group-addon">
                                      <i class="material-icons">lock</i>
                                  </span>
                                  <div class="form-line">
                                      <input type="password" class="form-control" name="password1" placeholder="Password" required="">
                                  </div>
                              </div>

                              <div class="input-group addon-line">
                                  <span class="input-group-addon">
                                      <i class="material-icons">lock</i>
                                  </span>
                                  <div class="form-line">
                                      <input type="password" class="form-control" name="password2" placeholder="Repeat Password" required="">
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

                            <div class="box-footer text-center">
                               <button class="btn btn-primary waves-effect" type="submit">SAVE NEW ADMIN</button>
                            </div>

                          </form>
                        </div>
                      </div>
                </div>
            </div>
    </div>
</section>
