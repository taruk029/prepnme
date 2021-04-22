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
                <h5 class="breadcrumbs-title">Add Category</h5>
                <ol class="breadcrumbs">
                  <li><a href="<?php echo e(url('home')); ?>">Dashboard</a></li>
                  <li><a href="<?php echo e(url('add_category')); ?>">Add Category</a></li>
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
                        <form class="col s12" method="post" action="<?php echo e(url('add_category')); ?>">
                           <?php echo e(csrf_field()); ?>

                          <div class="row">
                            <div class="input-field col s12">
                              <input id="category" type="text" name="category" >
                              <label for="first_name" class="">Category Name</label>
                              <span class="form-text" style="color:red">
                                <?php if($errors->has('category')): ?>
                                    <strong><?php echo e($errors->first('category')); ?></strong>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\training\admin\resources\views/categories/add.blade.php ENDPATH**/ ?>