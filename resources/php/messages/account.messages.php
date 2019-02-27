<!-- --------- ACCOUNT --------- -->

<!-- Update user modal form -->
<div class="modal fade" id="update-user" tabindex="-1" role="dialog" aria-labelledby="update-user-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="update-user-title">Update user</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
            <!-- Form body -->

      <?php 
              if ($this->userSession->checkIfIndexExists('current-user'))
              $currentUser = $this->userSession->getValueByIndex('current-user', true);
      ?>

      <form action="" method="get" id="update-form">
  			<div class="form-group">
    			<label for="username">Username</label>
    			<input type="text" class="form-control" name="username" value="<?php if(!empty($currentUser->getUsername())) echo $currentUser->getUsername(); ?>" placeholder="Username">
  			</div>
            <div class="form-group">
    			<label for="name">Name</label>
    			<input type="text" class="form-control" name="name" value="<?php if(!empty($currentUser->getName())) echo $currentUser->getName(); ?>" placeholder="Name">
  			</div>
            <div class="form-group">
    			<label for="surname">Surname</label>
    			<input type="text" class="form-control" name="surname" value="<?php if(!empty($currentUser->getSurname())) echo $currentUser->getSurname(); ?>" placeholder="Surname">
  			</div>
            <div class="form-group">
    			<label for="email">Email</label>
    			<input type="email" class="form-control" name="email" value="<?php if(!empty($currentUser->getEmail())) echo $currentUser->getEmail(); ?>" placeholder="Email">
  			</div>
            <div class="form-group">
    			<label for="phone">Phone</label>
    			<input type="text" class="form-control" pattern="[0-9]{9}" name="phone" value="<?php if(!empty($currentUser->getPhone())) echo $currentUser->getPhone(); ?>" placeholder="Phone">
        </div>
          <input type="hidden" name="mod" value="user" />
          <input type="hidden" name="op" value="validateUpdate" />
          <input type="hidden" name="update-form" value="true">
          <button type="button" class="btn btn-warning" data-toggle="modal" data-dismiss="modal" data-target="#confirm-update">Update</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		  </form>

        <script>

        function submitForm() {
            $("#update-form").submit();
        }
        
        </script>
        
      </div>
    </div>
  </div>
</div>

<!-- User exists modal for update -->

<div class="modal" id="u-user-exists" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
    			<h5 class="modal-title">Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-toggle="modal" data-dismiss="modal" data-target="#update-user">Refill form</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Same parameters modal for update -->

<div class="modal" id="update-error" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>You have not provide all parameters</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-toggle="modal" data-dismiss="modal" data-target="#update-user">Refill form</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Update success -->

<div class="modal" id="update-success" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>User updated successfully</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete success -->

<div class="modal" id="delete-success" data-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Info</h5>
                <a href="index.php?mod=user&op=login" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <p>User deleted successfully</p>
            </div>
            <div class="modal-footer">
                <a href="index.php?mod=user&op=login" class="btn btn-secondary">Close</a>
            </div>
        </div>
    </div>
</div>

<!-- Confirm delete modal -->

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirm-delete-title">Confirm delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        User will be permanently removed. Are you sure?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
        <a href="index.php?mod=user&op=validateDelete" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>

<!-- Confirm update modal -->

<div class="modal fade" id="confirm-update" tabindex="-1" role="dialog" aria-labelledby="confirm-update-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirm-update-title">Confirm update</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
        User will be permanently modified. Confirm operation?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-toggle="modal" data-dismiss="modal" data-target="#update-user">No</button>
        <button type="button" onclick="submitForm()" class="btn btn-warning">Yes</button>
      </div>
    </div>
  </div>
</div>