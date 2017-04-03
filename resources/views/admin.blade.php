@extends('layouts.home')

@section('contentDashboard')
 <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" ng-controller="newUserController" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">New user</h5>
            </div>
            <div class="modal-body">
            <div class="container" style="padding-bottom: 0px ">
              <form name="editForm" novalidate>
               {{ csrf_field() }}     
                <div class="form-group" style="padding: 20px 20px">
                      <!-- <div class="container" style="height:0px"> -->
                          <label for="f_name" class="col-md-4 control-label" style="text-align: right;">First name</label>
                          <div class="col-md-6" >
                            <input id="f_name" type="text" class="form-control" name="f_name" style="margin-top: -9px; margin-left: -15px" ng-model="f_name">
                          </div>

                          <label for="l_name" class="col-md-4 control-label" style="text-align: right;margin-top: 18px">Last name</label>
                          <div class="col-md-6" style="margin-top: 20px">
                            <input id="l_name" type="text" class="form-control" name="l_name" style="margin-top: -9px; margin-left: -15px" ng-model="l_name">
                          </div>

                          <label for="email" class="col-md-4 control-label" style="text-align: right;margin-top: 18px">Email</label>
                          <div class="col-md-6" style="margin-top: 20px">
                            <input id="email" type="text" class="form-control" name="email" style="margin-top: -9px; margin-left: -15px" ng-model="email">
                          </div>

                          <label for="role" class="col-md-4 control-label" style="text-align: right;margin-top: 18px">Role</label>
                          <div class="col-md-6" style="margin-top: 20px">
                            <select class="form-control"  name="elType" ng-model="role" data-placeholder="Choose element type: Healdine, Paragraph, Image" style="margin-top: -9px; margin-left: -15px" required>
                              <option value="2"
                              >User</option>
                              <option value="3">Seller</option>
                              <option value="1" >Admin</option>
                              <!-- <option value="Image" ng-disabled="true">Image</option> -->
                          </select>
                          </div>


                         
                      <!-- </div> -->
                </div>
              </form>
              <div class="col-md-12" style="margin-top:11px;color: #CC2121">
                @{{error.firstName[0]}}
                @{{error.lastName[0]}}
                @{{error.email[0]}}
                @{{error.role[0]}}
              </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" ng-click="emptyErrorArray()" >Close</button>
              <button type="submit" class="btn btn-primary" style="background: #f8951d; border-color: #f8951d" ng-click="submitNewUserForm()">Add</button>
            </div>
          </div>
        </div>
      </div>
  <!-- CONTENT -->   
  <!-- title -->
  <div class="container" ng-controller="profileController">
    <div class="page-header"><h1>SETTINGS</h1></div>
    <!-- Sidebar -->
    <div class="col-xs-12 col-sm-2 sidebar">
      <ul>
        <li><a href="{!! route('profile') !!}">PROFILE</a></li>
        @if(Auth::user()->hasRole('admin'))
        <li>ADMIN PANEL</li>
        @endif
        <li><a href="{!! route('billing') !!}">BILLING</a></li>
        <li><a href="{!! route('new') !!}"><button type="button" class="btn btn-default add-website"><span class="plus">+</span>ADD WEBSITE</button></a></li>
      </ul>
    </div>
    <button class="btn btn-info" style="background: #f8951d; margin-bottom: 10px; border-color: #f8951d" data-toggle="modal" data-target="#addUserModal">Add new user</button>
    <div class="usage-wrapper"> 

          
          <table class="table">
            <thead>
              <th>First name</th>
              <th>Last name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Registered from</th>
              <th>Actions</th>
              
            </thead>  
            <tbody>
              @foreach($users as $user)
              <tr>
                <td>{{$user->first_name}}</td>
                <td>{{$user->last_name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->roleName($user->role_id)}}</td>
                <td>{{$user->userStatus($user->deleted_at)}}</td>
                <td>{{$user->created_at}}</td>
                <td>
                  <button class="btn btn-info btn-xs" disabled>Update</button>
                  @if($user->userStatus($user->deleted_at) == 'Active')
                    <a href="{!! route('deactivate2', $user->id) !!}" class="btn btn-danger btn-xs">Deactivate</a>
                  @else
                    <a  href="{!! route('activate', $user->id) !!}" class="btn btn-success btn-xs">Activate</a>
                  @endif
                </td>
              </tr>
               @endforeach
            </tbody> 

          </table>
          @if($users->isEmpty())
          <div class="col-md-12" style="text-align: center;padding: 20px 0px;background: #efeded">
            <span style="color: black">No users!</span>
          </div>
          @endif
        </div>
  </div>
@endsection