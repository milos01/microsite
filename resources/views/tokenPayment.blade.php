@extends('layouts.home')

@section('contentDashboard')
<div class="container"> 
@if(!$elements->isEmpty())
  <div class="row">
    <div class="col-sm-8 add-element-wrapper">
      <h1 class="token-summary-title">Turnaround Time</h1>
      <div class="turnaround-wrapper">
            <div><input type="radio" name="tat"  ng-model="tat" value="whenever" ng-checked="true"><label>Whenever</label></div>
            <div><input type="radio" name="tat" ng-model="tat" value="15"><label>1-5 Hours</label></div>
            <div><input type="radio" name="tat" ng-model="tat" value="510"><label>5-10 Hours</label></div>
            <div><input type="radio" name="tat" ng-model="tat" value="1015"><label>10-15 Hours</label></div>
            <div><input type="radio" name="tat" ng-model="tat" value="1520"><label>15-20 Hours</label></div>
      </div>
    </div>
  </div> 
  
  <div class="ibox-content" ng-controller="braintreeController">
      <div class="panel-group payments-method" id="accordion">
          <div class="panel panel-default">
              <div class="panel-heading" style="background: white">
              <h2>Summary</h2>
                  <strong>Price:</strong> <span class="text-navy">${{$total}}</span>
                  <p class="m-t">
                      Please enter your preferred payment method below. You can use a credit card or prepay through PayPal. 
                  </p>
                  <div class="panel-body">
                      <div class="row">
                          <div class="col-md-12">

                              <form method="POST" action="{!! route('payment') !!}">
                                    {{ csrf_field() }}
                                    <div id="dropin-container"></div>
                                    
                                    <input type="submit" class="btn btn-default" value="Make payment" style="margin-top: 20px">
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  @endif
</div> 
@endsection
