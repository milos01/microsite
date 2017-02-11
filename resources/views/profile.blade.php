@extends('layouts.home')

@section('contentDashboard')

  <!-- CONTENT -->   
  <!-- title -->
  <div class="container" ng-controller="profileController">
    <div class="page-header"><h1>SETTINGS</h1></div>
    <!-- Sidebar -->
    <div class="col-xs-12 col-sm-2 sidebar">
      <ul>
        <li>PROFILE</li>
        <li><a href="{!! route('billing') !!}">BILLING</a></li>
        <li><button type="button" class="btn btn-default add-website"><span class="plus">+</span>ADD WEBSITE</button></li>
      </ul>
    </div>
    <div class="col-xs-12 col-sm-10 side-content">
      <p class="full-name">{{Auth::user()->first_name}} {{Auth::user()->last_name}}<a class="edit" ng-click="openReportModal('user')">edit</a></p>
      <ul>
        <li>
          <p><span class="type">Email: </span>{{Auth::user()->email}}<a class="edit" ng-click="openReportModal('email')">edit</a></p>
          <button type="submit" class="manage-profile"></button>
        </li>
        <li>
          <p><span class="type">Password: </span>*********<a class="edit" ng-click="openReportModal('password')">edit</a></p>
          <button type="submit" class="manage-profile"></button></li>
        </li>
        <li>
          <p><span class="type">Phone: </span>
           {{Auth::user()->phone}}
          <a class="edit" ng-click="openReportModal('phone')">edit</a></p>
          <button type="submit" class="manage-profile"></button></li>
        </li>
        <li>
          <p><span class="type">Memeber Since: </span>
            @dateformat(Auth::user()->created_at)
          </p>
         </li>
        </li>
      </ul>
      <form method="POST" action="{!! route('deactivate') !!}">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <button type="submit" class="deactivate-button">Deactivate Account</button>
      </form>
    </div>
  </div> 
@endsection