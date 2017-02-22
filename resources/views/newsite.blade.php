@extends('layouts.home')

@section('contentDashboard')

  <!-- CONTENT -->   
  <!-- title -->
  <div class="container" >
    <div class="page-header"><h1>CHOOSE WEBSITE</h1></div>
    <!-- Sidebar -->
    <div class="col-xs-12 col-sm-2 sidebar">
      <!-- <ul>
        <li>PROFILE</li>
        <li><a href="{!! route('billing') !!}">BILLING</a></li>
        <li><a href="{!! route('new') !!}"><button type="button" class="btn btn-default add-website"><span class="plus">+</span>ADD WEBSITE</button></a></li>
      </ul> -->
    </div>
    <div class="col-xs-12 col-sm-10 side-content">
      @foreach ($themes as $theme)
      <div class="modal fade" id="myModal{{$theme->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" ng-controller="websiteController">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{$theme->name}} theme (ID: {{$theme->theme_id}})</h5>
            </div>
            <div class="modal-body">
            <div class="container" style="padding-bottom: 0px ">
              <form name="editForm" novalidate>
               {{ csrf_field() }}     
                <div class="form-group" style="padding: 20px 20px">
                      <!-- <div class="container" style="height:0px"> -->
                          <label for="companyName" class="col-md-4 control-label" style="text-align: right;">Company name</label>
                          <div class="col-md-6">
                            <input id="companyName" type="text" class="form-control" name="companyName" style="margin-top: -9px; margin-left: -15px" ng-model="companyName">
                          </div>

                          <label for="websiteTitle" class="col-md-4 control-label" style="text-align: right;margin-top: 18px">Website title</label>
                          <div class="col-md-6" style="margin-top: 20px">
                            <input id="websiteTitle" type="text" class="form-control" name="websiteTitle" style="margin-top: -9px; margin-left: -15px" ng-model="websiteTitle">
                          </div>

                          <label for="domain" class="col-md-4 control-label" style="text-align: right;margin-top: 18px">Domain</label>
                          <div class="col-md-6" style="margin-top: 20px">
                            <input id="domain" type="text" class="form-control" name="domain" style="margin-top: -9px; margin-left: -15px" ng-model="domain">
                          </div>
                      <!-- </div> -->
                </div>
              </form>
              <div class="col-md-12" style="margin-top:11px;color: #CC2121">
                @{{error.companyName[0]}}
                @{{error.websiteTitle[0]}}
                @{{error.domain[0]}}
              </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" style="background: #f8951d; border-color: #f8951d" ng-click="submitForm({{$theme->id}})">Submit & Checkout</button>
            </div>
          </div>
        </div>
      </div>


      <div class="col-md-3" style="margin: 10px 20px;" id="imageHolder">
        <div class="col-md-12" style="border:1px solid white;height: 190px;background: #f8f8f8; text-align: center;">
          <div class="page-header" data-toggle="modal" data-target="#myModal{{$theme->id}}" style="margin-top: 75px">{{$theme->name}}</div>
          <button id="toggleSelectButton" data-toggle="modal" data-target="#myModal{{$theme->id}}" class="btn btn-default" style="margin-top: -10px; background: #f8951d;border-color: #f8951d; color: white">Select</button>
        </div>
        <div class="col-md-12" style="border:1px solid white;text-align: right; padding: 10px 5px;background: #f8f8f8" >${{$theme->price}}</div>
      </div>
      @endforeach
      
    </div>
  </div> 
@endsection