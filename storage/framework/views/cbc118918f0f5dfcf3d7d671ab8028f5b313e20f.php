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
                <h5 class="breadcrumbs-title">Questions</h5>
                <ol class="breadcrumbs">
                  <li><a href="<?php echo e(url('home')); ?>">Dashboard</a></li>
                  <li><a href="<?php echo e(url('questions')); ?>">Questions</a></li>
                </ol>
              </div>
              <div class="col s2 m6 l6">
                <a class="btn waves-effect waves-light breadcrumbs-btn cyan right" href="<?php echo e(url('add_question')); ?>">Add New Question
                  <i class="material-icons left">add</i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <!-- <div id="work-collections">
              <div class="row">
              <div class="col s12 m12 l12">
                <div class="card-panel">
                  <div class="row">
                    <form class="col s12" >
                      <h4 class="header2">Search</h4>
                      <div class="row">
                        <div class="input-field col s4">
                          <select class="validate">
                            <option value="" disabled selected>Select Question Type</option>
                            <?php $__currentLoopData = $question_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($row->id); ?>"><?php echo e($row->question_type); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                        </div>
                        
                      </div>
                      <div class="row">
                              <div class="input-field col s12">
                                <button class="btn waves-effect waves-light right cyan" type="submit" name="action">Search
                                  <i class="material-icons right">youtube_searched_for</i>
                                </button>
                              </div>
                            </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            </div>
 -->

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
                              <th data-field="name">Section</th>
                              <th data-field="name">Question</th>
                              <th data-field="name">Category</th>
                              <th data-field="name">Question Type</th>
                              <th data-field="name">Difficulty Level</th>
                              <th data-field="price">Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rowq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                              <td><?php echo e($rowq->test_name); ?></td>
                              <td><?php echo e($rowq->section); ?></td>
                              <td><?php echo $rowq->question ?></td>
                              <td><?php echo e($rowq->category); ?></td>
                              <td><?php echo e($rowq->question_type); ?></td>
                              <td><?php echo e($rowq->difficulty_level); ?></td>
                              <td>
                                <a href="<?php echo e(url('edit_question/'.$rowq->id)); ?>" title="Edit Question">
                                  <i class="material-icons left">edit</i>
                                </a>
                                 <a href="<?php echo e(url('delete_question/'.$rowq->id)); ?>" title="Delete Question" onclick="return confirm('This question will be permanently deleted from the test. Are you sure to delete the question!');">
                                    <i class="material-icons left">delete_forever</i>
                                  </a>
                                <!-- <?php if($rowq->is_active == 1): ?>
                                  <a href="<?php echo e(url('deactivate_category/'.$rowq->id)); ?>" title="Make Inactive">
                                    <i class="material-icons left">clear</i>
                                  </a>
                                <?php else: ?>
                                  <a href="<?php echo e(url('deactivate_category/'.$rowq->id)); ?>" title="Make Active">
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
          </div>
          <!--end container-->
        </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\training\admin\resources\views/questions/index.blade.php ENDPATH**/ ?>