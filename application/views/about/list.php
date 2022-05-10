<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>About Wohem</h2>
        </div>
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="container-fluid">

            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card" style="margin-bottom: 40px;">
       
                        <div class="body">
                          <div >
                          <?php
                                  forEach($data as $about){
                                  ?>    
                                                  <style>
                                                    .aboutus{
                                                        /* width: auto; */
                                                      background-image: url('<?php echo $about->image?>');
                                                      height: 300px;
                                                      background-position: center;
                                                      background-size: cover;
                                                      background-repeat: no-repeat;
                                                    }
                                                </style>
                                 <div class="margin:40px auto;">
                                  <div class="row">
                                       <div  class="col-md-5 col-sm-5 col-xs-12  aboutus">
                                       <!-- <img class="aboutus" src="https://static.politico.com/44/15/06ce278d4ff8b60e5f1b354f6180/200710-catholic-church-gty-773.jpg" alt="" width="400px" > -->
                                       </div>
                                       <div class="col-md-7 col-sm-8 col-xs-12">
                                       <p class="" style=""><?php echo $about->body;?></p>
                                           </div>
                                   </div>
                                 </div>
                                   <?php }
                                   ?>
                                   <hr>
                        </div>
                        <div class="box-footer text-center " style="margin-bottom: 0px;">
                               <a class="btn btn-primary waves-effect" type="submit" href="<?php echo base_url(); ?>about/EditAbout">Edit </a>
                            </div>
                </div>

            </div>
    </div>
</section>