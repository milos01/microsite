@extends('layouts.home')

@section('contentDashboard')
<!-- CONTENT -->  
  <!-- Upgrade Notification -->
  <div class="notification-trial-bar">
    <p class="notification-trial">You Free Trial expires in <span class="trial-number">5 days</span>. Please  upgrade your account on time in order to avoid stopping your site development.</p>
    <button type="submit" id="upgrade-button" class="btn btn-default">UPGRADE</button>
  </div>
  <!-- title -->
  <div class="container">
    <div class="page-header"><h1>WEBSITES</h1></div>
  </div>  

  <!-- TABLE -->
  <div class="container">
    <!-- first row starts -->    
    <div class="table-name-wrapper">
      <p class="table-name">Site Name</p> 
    </div>
    <div id="table-row" class="row">      
      <a href="#" class="website-link">
        <div class="table-wrapper">   
          <button type="submit" class="manage"></button>
          <!-- thumbnail -->
          <div class="table-column">
            <div class="table-header"><p>Website</p></div>
            <div id="website" class="table-data"><p>My Plumbing Website</p></div>
            <div id="website-thumbnail-img"></div>
          </div>        
          <!-- theme IDl -->
          <div class="table-column">
            <div class="table-header"><p>Theme ID</p></div>
            <div class="table-data"><p>9576</p></div>
          </div>
          <!-- Domain -->
          <div class="table-column">
            <div class="table-header"><p>Domain</p></div>
            <div class="table-data"><p>www.nyplumber.com</p></div>
          </div>
          <!-- Created -->
          <div class="table-column">
            <div class="table-header"><p>Created</p></div>
            <div class="table-data"><p>11/9/2016</p></div>
          </div>
          <!-- Price -->
          <div class="table-column">
            <div class="table-header"><p>Monthly Price</p></div>
            <div class="table-data"><p>$75</p></div>
          </div>
        </div>
      </a>
    </div>
    <!-- first row ends -->

    <!-- add website button -->
    <a href="{!! route('new') !!}"><button type="button" class="btn btn-default add-website"><span class="plus">+</span>ADD WEBSITE</button>
  </div></a>
@endsection