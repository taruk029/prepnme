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
                <h5 class="breadcrumbs-title">Edit Assign Section</h5>
                <ol class="breadcrumbs">
                  <li><a href="<?php echo e(url('home')); ?>">Dashboard</a></li>
                  <li><a href="<?php echo e(Request::url()); ?>">Edit Assign Section</a></li>
                </ol>
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
                    <div class="card-panel">
                      <div class="row">
                        <form class="col s12" method="post" action="<?php echo e(url('update_test_section')); ?>">
                          <?php echo e(csrf_field()); ?>

                          <div class="row">
                            <div class="input-field col s12">
                                <select name="test" id="test" required="required">
                                  <option value="" selected>Select Test </option>
                                  <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($row->id); ?>" selected="selected"><?php echo e($row->test_name); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                 <?php if($errors->has('test')): ?>
                                    <strong><?php echo e($errors->first('test')); ?></strong>
                                <?php endif; ?>
                            </div>
                          </div>
                          <h4 class="header2">Please Select Sections</h4><br>
                          <div class="row">
                            <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col s6 m3">
                              <label class="container_label_check"><?php echo e($row->section); ?>  (<?php echo e("ID- ".$row->id); ?>)
                                  <input type="checkbox" name="section[]" value="<?php echo e($row->id); ?>" <?php if(in_array($row->id, $section_tests_array)) echo "checked='checked'"; ?> >
                                  <span class="checkmark"></span>
                                </label>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </div>
                            <div class="row">
                              <div class="input-field col s12">
                                <button class="btn waves-effect waves-light right cyan" type="submit" name="action">Update
                                  <i class="material-icons right">send</i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </form>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\training\admin\resources\views/test_sections/edit.blade.php ENDPATH**/ ?>