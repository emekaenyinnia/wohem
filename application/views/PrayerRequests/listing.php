
<section class="content">
    <!-- Page content-->
    <div class="container-fluid">
        <div class="block-header">
            <h2>Prayer Requests </h2>
        </div>


            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">

                        <div class="body">
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
                          <div style="overflow-x:auto;">
                            <table id="categories-table" class="table table-responsive table-bordered table-striped table-hover exportable">
                                <thead>
                                <tr>
                                  <th>Id</th>
                                  <th>Name</th>
                                  <th>GuestorMember</th>
                                  <th>message</th>
                                  <th>audio</th>
                                  <th>video</th>
                                  <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                              <tbody>
                                  <?php
                                  $count=1;
                                  forEach($Prayer_Request as $record){
                                
                                  ?>
                                
                                  <tr>
                                  <td><?php echo $count; ?></td>
                                
                                  <?php if($record->name != '' ){ echo  "<td>".$record->name."</td>"; } else { echo '<td> anonymous  </td>'; }?>
                                    <td style="text-align:center;"><?php echo $record->guestormember; ?></td>
                                    <td><?php echo $record->messagebox; ?></td>
                                    <?php if($record->audio !== 'null'){ echo '<td>
                                   <audio controls>
                                   <source src="'.$record->audio.'" type="audio/mp4">
                                 Your browser does not support the audio element.
                                 </audio>
                                   </td> '; } else {echo  ' <td>No audio</td>';}?>

                                    <?php if($record->video !== 'null'){ echo '<td style="width:340px">
                                      <video width="320" height="227" controls>
                                      <source src="'.$record->video.'" type="video/mp4">
                                      Your browser does not support the video tag.
                                      </video>  
                                   </td> '; } else {echo  ' <td>No video</td>';}?>
                                    <td class="text-center">
                                        <button onclick="delete_item(event)" data-type="prayer_request" data-id="<?php echo $record->id; ?>" type="button" class="btn btn-danger btn-lg m-l-15 waves-effect" style="float: none;">
                                         <i style="color:white;margin-bottom:5px;"  class="material-icons list-icon" data-type="prayer_request" data-id="<?php echo $record->id; ?>">delete</i>
                                        </button>
                                      </div>
                                    </td>
                                   </tr>
                                   <?php $count++;}
                                   ?>
                                </tbody>
                            </table>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
</section>
