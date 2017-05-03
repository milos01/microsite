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
      <div class="modal fade select-site-modal" id="myModal{{$theme->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" ng-controller="websiteController" data-backdrop="static" data-keyboard="false">
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
                          
                          <div class="col-md-12">
                            <input id="companyName" type="text" class="form-control" name="companyName" style="margin-top: -9px; margin-left: -15px" ng-model="companyName" placeholder="Company Name">
                          </div>

                          
                          <div class="col-md-12" style="margin-top: 20px">
                            <input id="websiteTitle" type="text" class="form-control" name="websiteTitle" style="margin-top: -9px; margin-left: -15px" ng-model="websiteTitle" placeholder="Website Title">
                          </div>

                          
                          <div class="col-md-12" style="margin-top: 20px">
                            <input id="domain" type="text" class="form-control" name="domain" style="margin-top: -9px; margin-left: -15px" ng-model="domain" placeholder="Domain">
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
              <button type="button" class="btn btn-secondary modal-close-btn" data-dismiss="modal" ng-click="emptyErrorArray(error)">Close</button>
              <button type="submit" class="btn btn-primary modal-submit-btn"ng-click="submitForm({{$theme->id}})">Submit & Checkout</button>
            </div>
          </div>
        </div>
      </div>


      <div class="col-md-3" style="margin: 10px 20px; overflow:hidden;" id="imageHolder">

        <div class="col-md-12" style="border:1px solid white;background: #f8f8f8; text-align: center;padding-right: 0px;padding-left: 0px; max-height: 190px">
        <img src="/img/{{$theme->picture}}" style="width:100%">
          <div style="position: absolute;width: 100%;top: 0px;background: black;padding:10px 0px;opacity: 0.6;color: white">
            {{$theme->name}}
          </div>
         
        </div>
        <div class="col-md-12" style="border:1px solid white;text-align: right; padding: 10px 5px;background: #f8f8f8" ><span class="pull-left">
           <a id="toggleSelectButton" data-toggle="modal" data-target="#myModal{{$theme->id}}"  style="margin-top: -10px;cursor: pointer; color: #f8951d">
                SELECT
            </a>
           </span>${{$theme->price}}</div>
      </div>
      @endforeach
      
    </div>
  </div> 
@endsection