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
                <h5 class="breadcrumbs-title">Add Section</h5>
                <ol class="breadcrumbs">
                  <li><a href="<?php echo e(url('home')); ?>">Dashboard</a></li>
                  <li><a href="<?php echo e(url('add_section')); ?>">Add Section</a></li>
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
                        <form class="col s12" method="post" action="<?php echo e(url('add_section')); ?>">
                          <?php echo e(csrf_field()); ?>

                          <div class="row">
                            <div class="input-field col s12">
                              <input id="section" type="text" name="section" required="required" maxlength="255" value="<?php echo e(old('section')); ?>">
                              <label for="first_name" class="">Section Name</label>
                               <?php if($errors->has('section')): ?>
                                    <strong><?php echo e($errors->first('section')); ?></strong>
                                <?php endif; ?>
                            </div>
                          </div>                          
                          <div class="row">
                            <div class="input-field col s12">
                              <select name="difficulty_level" id="difficulty_level" required="required">
                                <option value="" >Select Difficulty Level</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                              </select>
                               <?php if($errors->has('difficulty_level')): ?>
                                    <strong><?php echo e($errors->first('difficulty_level')); ?></strong>
                                <?php endif; ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="duration_in_mins" type="text" name="duration_in_mins" onkeypress="return NumbersOnly(event,this)" maxlength="3" required="required" value="<?php echo e(old('duration_in_mins')); ?>">
                              <label for="first_name" class="">Duration In Minutes</label>
                               <?php if($errors->has('duration_in_mins')): ?>
                                    <strong><?php echo e($errors->first('duration_in_mins')); ?></strong>
                                <?php endif; ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <textarea id="description" class="materialize-textarea" name="description" ><?php echo e(old('description')); ?>

                              </textarea>
                              <label for="first_name" class="">Description</label>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\training\admin\resources\views/sections/add.blade.php ENDPATH**/ ?>