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
                <h5 class="breadcrumbs-title">Sections</h5>
                <ol class="breadcrumbs">
                  <li><a href="<?php echo e(url('home')); ?>">Dashboard</a></li>
                  <li><a href="<?php echo e(url('sections')); ?>">Sections</a></li>
                </ol>
              </div>
              <div class="col s2 m6 l6">
                <a class="btn waves-effect waves-light breadcrumbs-btn cyan right" href="<?php echo e(url('assign_section')); ?>" style="margin-left: 5px;">Assign Test Section
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
                              <th data-field="price">Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                           <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                              <td><?php echo e($row->test_name); ?></td>
                              <td><?php echo e(App\Helpers\Helper::get_test_sections($row->test_id)); ?></td>
                              <td>
                                <a href="<?php echo e(url('edit_test_section/'.$row->test_id)); ?>" title="Edit Assign Section">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\training\admin\resources\views/test_sections/index.blade.php ENDPATH**/ ?>