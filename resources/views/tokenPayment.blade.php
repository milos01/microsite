@extends('layouts.home')

@section('contentDashboard')

{{ csrf_field() }}
<div class="container"> 
@if(!$elements->isEmpty())
   
  
  <div class="ibox-content" ng-controller="braintreeController" style="margin-top: 50px">
      <div class="panel-group payments-method" id="accordion">
          <div class="panel panel-default">
              <div class="panel-heading" style="background: white">
                
                 
                  <div class="col-md-12">
                  @if (session('bt_errors'))
                          @foreach(session('bt_errors') as $error)
                            <div class="alert alert-danger">
                                 {{$error->message}}
                            </div>
                            @endforeach
                  @endif
                  </div>
                  @if (Auth::user()->card_last_four == null)
                  <form method="POST" action="{!! route('payment') !!}" name="paymentForm" novalidate>

                    <div class="panel-body">

                        <div class="row">
                        <div class="col-md-12">
                            <div class="col-sm-8 add-element-wrapper" style="padding-left: 20px; padding-top: 0px;">
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

                                <h2>Summary</h2>
                                <strong>Price:</strong> <span class="text-navy">${{$total}}</span>
             
                          

                              <p class="m-t">
                                Please select your preferred payment method below. You can use a credit card or PayPal. 
                              </p>

                              <!-- <div class="col-sm-5 add-element-wrapper" id="paymentPart1" style="padding-top: 20px; margin-left: -15px; margin-bottom: -30px; display: none">
                                <div class="add-element-expanded" style="border-bottom: none">
                                  <div class="form-group col-md-6" ng-class="{ 'has-error' : paymentForm.cardholder.$invalid && !paymentForm.cardholder.$pristine}">
                                    <input type="text" class="form-control" id="new-headline" name="cardholder" ng-model="cardholder" placeholder="Cardhodler name" required />
                                  </div>
                              </div> -->
                                
                              </div>
                              <div id="dropin-container"></div>
                              <input type="hidden" name="total" value="{{$total}}">
                              <input type="submit" class="btn btn-default" value="Make payment" id="paymentPart2" style="margin-top: 20px;display: none">  
                            </div>
                        </div>
                  
                    {{ csrf_field() }}
                  </form>
                  @else
                  <form method="POST" action="{!! route('samecardPaymentOneTime') !!}">

                    <div class="panel-heading" style="background: white; margin-top:30px">
                    <div class="row">
                                <div class="col-sm-8 add-element-wrapper" style="padding-left: 20px; padding-top: 0px;">
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

                                <h2>Summary</h2>
                                <strong>Price:</strong> <span class="text-navy">${{$total}}</span>
             
                                <h2>Pay with same card <h3>{{Auth::user()->card_brand}}: **** **** **** {{Auth::user()->card_last_four}}</h3></h2>
                                <input type="hidden" name="total" value="{{$total}}">
                                <button type="submit" class="btn btn-default" ng-click="clickPayButt()" style="margin-top: 30px;">Make payment 
                                <i ng-show="showSpin"  class="fa fa-spinner fa-spin fa-fw" ng-cloak></i>
                                <span class="sr-only">Loading...</span></button>
                                <a href="{!! route('removePayment') !!}" type="button" class="btn btn-danger" style="margin-top: 30px">Remove this card</a>
                    </div>
                     {{ csrf_field() }}
                  </form>
                  @endif
              </div>
          </div>
      </div>
  </div>
  @endif
</div> 
@endsection




