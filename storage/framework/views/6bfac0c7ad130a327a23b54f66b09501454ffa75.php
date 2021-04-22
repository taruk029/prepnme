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
                <h5 class="breadcrumbs-title">Tests Results</h5>
                <ol class="breadcrumbs">
                  <li><a href="<?php echo e(url('home')); ?>">Dashboard</a></li>
                  <li><a href="<?php echo e(url('categories')); ?>">Tests Results</a></li>
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
                  <div class="col s12">
                    <div class="card-panel">
                  <div id="responsive-table">
                    <div class="row">
                      <div class="col s12">
                        <table id="table_id" class=" display responsive-table">
                          <thead>
                            <tr>
                              <th data-field="id">Sr. No.</th>
                              <th data-field="name">Test</th>
                              <th data-field="name">Users</th>
                              <th data-field="name">Date</th>
                              <th data-field="price">Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                              <?php $i = 1; ?>
                            <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                              <td><?php echo e($i); ?></td>
                              <td><?php echo e($row->test_name); ?></td>
                              <td><?php echo e($row->user_login); ?></td>
                              <td><?php
                                $date=date_create($row->created_at);
                                echo date_format($date,"d/m/Y");
                              ?></td>
                              <td>
                                <a href="<?php echo e(url('admin_analysis/'.base64_encode($row->user_id).'/'.base64_encode($row->test_id).'/'.base64_encode(0))); ?>" title="View Test Results" target="_new">
                                  View Results
                                </a>
                               
                              </td>
                            </tr>
                            <?php $i++; ?>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Prepnme\resources\views/result/index.blade.php ENDPATH**/ ?>