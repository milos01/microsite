@extends('layouts.home')

@section('contentDashboard')
<!-- CONTENT -->  
  <!-- Upgrade Notification -->


  @include('templates.notifyBar')
   
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
     @if($userWebsites->isEmpty())
          <div class="col-md-12" style="text-align: center;padding: 20px 0px;background: whitesmoke">
            <span style="color: black">No active websites!</span>
          </div>
    @else     
      
         

          @foreach($userWebsites as $website)
          <a href="#" class="website-link">
          <div class="table-wrapper">   
            <button type="submit" class="manage"></button>
            <!-- thumbnail -->
            <div class="table-column col-md-2">
              <div class="table-header"><p>Website</p></div>
              <div id="website" class="table-data"><p>{{$website->title}}</p></div>
              <div id="website-thumbnail-img">Image here</div>
            </div>        
            <!-- theme IDl -->
            <div class="table-column">
              <div class="table-header"><p>Theme ID</p></div>
              <div class="table-data"><p>{{$website->theme->theme_id}}</p></div>
            </div>
            <!-- Domain -->
            <div class="table-column">
              <div class="table-header"><p>Domain</p></div>
              <div class="table-data"><p>{{$website->domain}}</p></div>
            </div>
            <!-- Created -->
            <div class="table-column">
              <div class="table-header"><p>Created</p></div>
              <div class="table-data"><p>@dateformat($website->created_at)</p></div>
            </div>
             <!-- Expire -->
            <!-- <div class="table-column">
              <div class="table-header"><p>Expire</p></div>
              <div class="table-data"><p>@dateformat($website->expire_at)</p></div>
            </div>
             <!-- Status -->
            <!-- <div class="table-column">
              <div class="table-header"><p>Status</p></div>
              <div class="table-data">
                @if($website->active === 1)
                 <p>Active</p>
                @else
                 <p>Not active</p>
                @endif
              </div>
            </div> -->
            <!-- Price -->
            <div class="table-column">
              <div class="table-header"><p>Monthly Price</p></div>
              <div class="table-data"><p>${{$website->theme->price}}</p></div>
            </div>
            </div>
          </a>
          @endforeach
        
      @endif
    </div>
    <!-- first row ends -->

    <!-- add website button -->
    <a href="{!! route('new') !!}"><button type="button" class="btn btn-default add-website"><span class="plus">+</span>ADD WEBSITE</button>
  </div></a>
@endsection