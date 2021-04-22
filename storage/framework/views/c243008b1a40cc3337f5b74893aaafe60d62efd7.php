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
                <h5 class="breadcrumbs-title">Add Test</h5>
                <ol class="breadcrumbs">
                  <li><a href="<?php echo e(url('home')); ?>">Dashboard</a></li>
                  <li><a href="<?php echo e(url('add_test')); ?>">Add Test</a></li>
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
                        <form class="col s12" method="post" action="<?php echo e(url('add_test')); ?>">
                           <?php echo e(csrf_field()); ?>

                          <div class="row">
                            <div class="input-field col s12">
                              <input id="test_name" type="text" name="test_name" required="required" value="<?php echo e(old('test_name')); ?>" >
                              <label for="first_name" class="">Test Name</label>
                              <span class="form-text" style="color:red">
                                <?php if($errors->has('test_name')): ?>
                                    <strong><?php echo e($errors->first('test_name')); ?></strong>
                                <?php endif; ?>
                            </span>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                                <select id="user_category" name="user_category" required="required">
                                  <option value="">Select User Type</option>
                                  <option value="1">Free</option>
                                  <option value="2">Premium</option>
                                </select>
                                <span class="form-text" style="color:red">
                                <?php if($errors->has('user_category')): ?>
                                    <strong><?php echo e($errors->first('user_category')); ?></strong>
                                <?php endif; ?>
                            </span>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                                <select id="membership_level" name="membership_level" required="required">
                                  <option value="">Select Membership Level</option>
                                  <?php if($membership_level): ?>
                                    <?php $__currentLoopData = $membership_level; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rowr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <option value="<?php echo e($rowr->id); ?>"><?php echo e($rowr->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  <?php endif; ?>
                                </select>
                                <span class="form-text" style="color:red">
                                <?php if($errors->has('membership_level')): ?>
                                    <strong><?php echo e($errors->first('membership_level')); ?></strong>
                                <?php endif; ?>
                            </span>
                            </div>
                          </div>
                            <div class="row">
                              <div class="input-field col s12">
                                <button class="btn waves-effect waves-light right cyan" type="submit" name="action">Submit
                                  <i class="material-icons right">send</i>
                                </button>
                              </div>
                            </div>
                        </form>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\training\admin\resources\views/tests/add.blade.php ENDPATH**/ ?>