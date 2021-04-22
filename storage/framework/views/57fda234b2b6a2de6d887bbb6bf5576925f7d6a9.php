<?php $__env->startSection('title', 'Practice Test'); ?>
<?php $__env->startSection('content'); ?>
     <section id="content">
       <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
          <!-- Search for small screen -->
          <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
          </div>
          <div class="container">
            <div class="row">
              <div class="col s10 m6 l6">
                <h5 class="breadcrumbs-title">Section Question</h5>
                <ol class="breadcrumbs">
                  <li><a href="<?php echo e(url('home')); ?>">Dashboard</a></li>
                  <li><a href="<?php echo e(url('sections')); ?>">Section Question</a></li>
                </ol>
              </div>
              <div class="col s2 m6 l6">
                <a class="btn waves-effect waves-light breadcrumbs-btn cyan right" href="<?php echo e(url('add_section_questions')); ?>" style="margin-left: 5px;">Assign Section Questions
                  <i class="material-icons left">add</i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <div id="work-collections">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="col s12">
                    <div class="card-panel">
                  <div id="responsive-table">
                    <div class="row">
                      <div class="col s12">
                        <table id="table_id" class=" display responsive-table">
                          <thead>
                            <tr>
                              <th data-field="name">Test</th>
                              <th data-field="name">Sections</th>
                              <th data-field="name">Questions</th>
                              <th data-field="price">Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                           <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                              <td><?php echo e($row->test_name); ?></td>
                              <td><?php echo e($row->section); ?></td>
                              <td>
                                  <a class="waves-effect waves-light modal-trigger" href="#modal1" onclick="javascript:get_questions(<?php echo e($row->id); ?>)">View Questions </a>
                                  <!-- Modal Structure -->
                                  <div id="modal1" class="modal">
                                    <div class="modal-content">
                                      <h4>Section Questions</h4>
                                      <p id="all_questions">
                                      </p>
                                    </div>
                                    <div class="modal-footer">
                                      <a href="#!" class="modal-close waves-effect waves-red btn-flat" onclick="close_blockui()">Close</a>
                                    </div>
                                  </div>
                              </td>
                              <td>
                                <a href="<?php echo e(url('edit_section_questions/'.$row->id)); ?>" title="Edit Assign Section">
                                  <i class="material-icons left">edit</i>
                                </a>
                                <!-- <?php if($row->is_active == 1): ?>
                                  <a href="<?php echo e(url('deactivate_test_section/'.$row->test_id)); ?>" title="Make Inactive">
                                    <i class="material-icons left">clear</i>
                                  </a>
                                <?php else: ?>
                                  <a href="<?php echo e(url('deactivate_test_section/'.$row->test_id)); ?>" title="Make Active">
                                    <i class="material-icons left">check</i>
                                  </a>
                                <?php endif; ?> -->
                              </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  </div>
                  </div>
                  </div>
                </div>
              </div>
            
            <!-- //////////////////////////////////////////////////////////////////////////// -->
          </div>
          <!--end container-->
        </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">

  function get_questions(id){
    var question_list = [];

    $.blockUI({ message: null });
    $.ajax({
        url: "<?php echo e(url('get_questions_bysection_id')); ?>",
        type: 'GET',
        data: {id:id},            
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(data){                   
            data = JSON.parse(data);
            var count = Object.keys(data).length;
            /*question_list.push("<ul>");*/
            var sn =1;
            for (var i = 0; i < count; i++) 
            { 
                question_list.push('<strong>'+sn+'</strong> -  <label style="color:#000000;">'+data[i].question+'</label><br>');
                sn++;
            }
            /*question_list.push("</ul>");*/
            var list = question_list.join("");            
            $("#all_questions").html(list);            
            //$.unblockUI();
        }
    });
  }
function close_blockui()
{
  $.unblockUI();
}
</script>
<script>

$(document).keyup(function(e) {
  if (e.which === 27) { // Escape key
    $.unblockUI();
  }
})
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\training\admin\resources\views/sections_question/index.blade.php ENDPATH**/ ?>