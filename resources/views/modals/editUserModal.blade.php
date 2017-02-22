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
    <div class="container" style="padding-bottom: 0px ">
        <form name="editForm" novalidate>
         {{ csrf_field() }}     
          <div class="form-group" style="padding: 20px 20px; margin-bottom: 0px">
            <div ng-show="edType === 'email'">
                <label for="email" class="col-md-4 control-label" style="text-align: right;">Email</label>
                <div class="col-md-6">
                  <input id="email" type="text" class="form-control" name="email" style="margin-top: -9px; margin-left: -15px" ng-model="email" placeholder="{{Auth::user()->email}}">
                </div>
            </div>

            <div ng-show="edType === 'user'">
                <label for="firstName" class="col-md-4 control-label" style="text-align: right;">First name</label>
                <div class="col-md-6">
                  <input id="firstName" type="text" class="form-control" name="firstName" style="margin-top: -9px; margin-left: -15px" ng-model="firstName" placeholder="{{Auth::user()->first_name}}">
                </div>

                <label for="lastName" class="col-md-4 control-label" style="text-align: right;margin-top: 18px">Last name</label>
                <div class="col-md-6" style="margin-top: 20px">
                  <input id="lastName" type="text" class="form-control" name="lastName" style="margin-top: -9px; margin-left: -15px" ng-model="lastName" placeholder="{{Auth::user()->last_name}}">
                </div>
            </div>
            <div ng-show="edType === 'password'">
                
                    <label for="oldPassword" class="col-md-4 control-label" style="text-align: right;">Old password</label>
                    <div class="col-md-6">
                      <input id="oldPassword" type="password" class="form-control" name="oldPassword" style="margin-top: -9px; margin-left: -15px" ng-model="oldPassword">
                    </div>

                    <label for="password" class="col-md-4 control-label" style="text-align: right;margin-top: 18px">New password</label>
                    <div class="col-md-6" style="margin-top: 20px">
                      <input id="password" type="password" class="form-control" name="password" style="margin-top: -9px; margin-left: -15px" ng-model="password">
                    </div>
              
            </div>
            <div ng-show="edType === 'phone'">
            <label for="phone" class="col-md-4 control-label" style="text-align: right;">Phone</label>
            <div class="col-md-6">
              <input id="phone" type="text" class="form-control" name="phone" style="margin-top: -9px;margin-left: -15px" ng-model="phone" placeholder="{{Auth::user()->phone}}">
            </div>
            </div>
            
          </div>
        </form>
        <div class="col-md-12" style="margin-top:11px;color: #CC2121">
            @{{error.firstName[0]}}
            @{{error.lastName[0]}}
            @{{error.email[0]}}
            @{{error.phone[0]}}
            @{{error.oldPassword[0]}}
            @{{error.password[0]}}
        </div>
    </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" ng-click="cancel()" data-dismiss="modal">Close</button>
  <button type="submit" class="btn btn-primary" ng-click="submitForm(edType)" style="background: #f8951d; border-color: #f8951d">Update @{{edType}}</button>
</div>
  
