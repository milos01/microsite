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
        <div class="website-link">
          <div class="table-wrapper">   
            <button type="submit" class="manage" ></button>
            <!-- thumbnail -->
            <div class="table-column col-md-2">
              <div class="table-header"><p>Website</p></div>
              <div id="website" class="table-data"><p>{{$website->title}}</p></div>
              <div id="website-thumbnail-img" style="overflow: hidden; max-height: 85px;">
                
                <img src="img/{{$website->theme->picture}}" style="width: 100%">
              
              </div>
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
              <div class="table-data"><p>{{$website->created_at->format('m/d/Y')}}</p></div>
            </div>
            
            <div class="table-column">
              <div class="table-header"><p>Status</p></div>
              <div class="table-data"><p>
                @if(!$website->deleted_at)
                  Active
                @else
                  Not active
                @endif
              </p></div>
            </div>

            <div class="table-column">
              <div class="table-header"><p>Actions</p></div>
              <div class="table-data">
                @if(!$website->deleted_at)
                  <a href="{!! route('deleteWebsite', $website->id) !!}" class="btn btn-danger btn-xs">Deactivate</a>
                @else
                  Deactivated at: {{$website->deleted_at->format('m/d/Y')}}
                @endif
                
              </div>
            </div>
            </div>
          </div>
        @endforeach
      @endif
    </div>
    <!-- first row ends -->

    <!-- add website button -->
    <a href="{!! route('new') !!}"><button type="button" class="btn btn-default add-website"><span class="plus">+</span>ADD WEBSITE</button>
  </div></a>
@endsection