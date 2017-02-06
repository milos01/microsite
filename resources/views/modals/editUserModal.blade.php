<!-- <div class="modal-header">
    <h3 class="modal-title">New Application</h3>
</div>
<div class="modal-body">
    <form name="newStaffForm" novalidate>
        <fieldset class="form-group">
            <label for="cardNumber">Application name</label>
            <input type="text" class="form-control" id="cardNumber" name="email" ng-model="vm.app_name" required>
        </fieldset>

        <fieldset class="form-group">
            <label for="cardNumber">Description</label>
            <input type="text" class="form-control" id="cardNumber" name="description" ng-model="vm.description" required>
        </fieldset>

         <fieldset class="form-group">
            <label for="cardNumber">DNS</label>
            <input type="text" class="form-control" id="cardNumber" name="dns" ng-model="vm.dns" required>
        </fieldset>

        <fieldset class="form-group">
            <label for="cardNumber">Repo link</label>
            <input type="text" class="form-control" id="cardNumber" name="repo_link" ng-model="vm.repo_link" required>
        </fieldset>

        <fieldset class="form-group">
            <label for="cardNumber">Version</label>
            <input type="text" class="form-control" id="cardNumber" name="version" ng-model="vm.version" required>
        </fieldset>
    </form>
</div>
<div class="modal-footer">
    <button class="btn btn-default" type="button" ng-click= "vm.addNewApp()">Add</button>
    <button class="btn btn-default" type="button" ng-click="vm.cancel()">Cancel</button>
</div> -->     
<div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel">Update @{{edType}}</h5>
</div>
<div class="modal-body">
    <form name="editForm" novalidate>
     {{ csrf_field() }}     
      <div class="form-group" style="padding: 20px 20px">
        <div ng-show="edType === 'email'">
        <label for="email" class="col-md-4 control-label" style="text-align: right;">Email</label>
        <div class="col-md-6">
          <input id="email" type="text" class="form-control" name="email" style="margin-top: -9px" ng-model="email">
        </div>
        </div>

        <div ng-show="edType === 'password'">
        <label for="email" class="col-md-4 control-label" style="text-align: right;">Password</label>
        <div class="col-md-6">
          <input id="email1" type="text" class="form-control" name="email1" style="margin-top: -9px" ng-model="email1">
        </div>
        </div>

        <div ng-show="edType === 'phone'">
        <label for="email" class="col-md-4 control-label" style="text-align: right;">Phone</label>
        <div class="col-md-6">
          <input id="email2" type="text" class="form-control" name="email2" style="margin-top: -9px" ng-model="email2">
        </div>
        </div>

      </div>
    </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" ng-click="cancel()" data-dismiss="modal">Close</button>
  <button type="submit" class="btn btn-primary" ng-click="submitForm(edType)" style="background: #f8951d; border-color: #f8951d">Update email</button>
</div>
  
