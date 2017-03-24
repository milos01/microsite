@extends('layouts.home')

@section('contentDashboard')
<form method="POST" action="{!! route('payment') !!}">
{{ csrf_field() }}
<div class="container"> 
@if(!$elements->isEmpty())
  <div class="row">
    <div class="col-sm-8 add-element-wrapper" style="padding-left: 20px">
      <h1 class="token-summary-title">Turnaround Time</h1>
      <div class="turnaround-wrapper">
            <div><input type="radio" name="tat" value="whenever" checked><label>Whenever</label></div>
            <div><input type="radio" name="tat" value="15"><label>1-5 Hours</label></div>
            <div><input type="radio" name="tat" value="510"><label>5-10 Hours</label></div>
            <div><input type="radio" name="tat" value="1015"><label>10-15 Hours</label></div>
            <div><input type="radio" name="tat" value="1520"><label>15-20 Hours</label></div>
      </div>
    </div>
  </div> 
  
  <div class="ibox-content" ng-controller="braintreeController">
      <div class="panel-group payments-method" id="accordion">
          <div class="panel panel-default">
              <div class="panel-heading" style="background: white">
              <div class="col-md-12">
                  <h2>Summary</h2>
                  <strong>Price:</strong> <span class="text-navy">${{$total}}</span>
              </div>
                  <div class="col-sm-4 add-element-wrapper" style="padding-top: 20px">
                    <div class="add-element-expanded" style="border-bottom: none">
                      <div class="form-group col-md-6" ng-class="{ 'has-error' : .newHeadline.$invalid && !.newHeadline.$pristine}">
                        <input type="text" class="form-control" id="new-headline" name="newHeadline" ng-model="oldForm.newHeadline" placeholder="First Name" />
                      </div>

                      <div class="form-group col-md-6" ng-class="{ 'has-error' : .newHeadline.$invalid && !.newHeadline.$pristine}">
                        <input type="text" class="form-control" id="new-headline" name="newHeadline" ng-model="oldForm.newHeadline" placeholder="Last Name" />
                      </div>

                      <div class="form-group col-md-12" ng-class="{ 'has-error' : .newHeadline.$invalid && !.newHeadline.$pristine}">
                        <input type="text" class="form-control" id="new-headline" name="newHeadline" ng-model="oldForm.newHeadline" placeholder="Street Address" />
                      </div>

                      <div class="form-group col-md-8" ng-class="{ 'has-error' : .newHeadline.$invalid && !.newHeadline.$pristine}">
                        <input type="text" class="form-control" id="new-headline" name="newHeadline" ng-model="oldForm.newHeadline" placeholder="City" />
                      </div>

                      <div class="form-group col-md-4" ng-class="{ 'has-error' : .newHeadline.$invalid && !.newHeadline.$pristine}">
                        <input type="text" class="form-control" id="new-headline" name="newHeadline" ng-model="oldForm.newHeadline" placeholder="Postal Code" />
                      </div>

                      <div class="form-group col-md-12" ng-class="{ 'has-error' : .newHeadline.$invalid && !.newHeadline.$pristine}">
                        <input type="text" class="form-control" id="new-headline" name="newHeadline" ng-model="oldForm.newHeadline" placeholder="Country" />
                      </div>
                    </div>
                    
                  </div>

                  <div>
                  
                  </div>
                  <div class="panel-body">
                      <div class="row">
                          <div class="col-md-12">
                            <p class="m-t">
                              Please select your preferred payment method below. You can use a credit card or PayPal. 
                            </p>
                            <div id="dropin-container"></div>
                            <input type="hidden" name="total" value="{{$total}}">
                            <input type="submit" class="btn btn-default" value="Make payment" style="margin-top: 20px">  
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  @endif
</div> 
</form>
@endsection
