@extends('layouts.home')

@section('contentDashboard')
 <!-- CONTENT -->   
  <div class="container">
    <div class="page-header"><h1>BILLING</h1></div>
    <!-- Sidebar -->
    <div class="col-sm-2 sidebar">
      <ul>
        <li><a href="{!! route('profile') !!}">PROFILE</a></li>
        <li>BILLING</li>
        <li><button type="button" class="btn btn-default add-website"><span class="plus">+</span>ADD WEBSITE</button></li>
      </ul>
    </div>
    <!-- tabs -->
    <div class="col-sm-10 ">
      <!-- Usage -->    
      <div id="table-row" class="row">   
      <!-- Table Title -->
      <div class="usage-title-wrapper">
        <p class="usage-title">Usage</p> 
      </div>      
        <div class="usage-wrapper"> 

        
          <table class="table">
            <thead>
              <th>Website</th>
              <th>Theme ID</th>
              <th>Domain</th>
              <th>Created</th>
              <th>Monthly Price</th>
            </thead>  
            <tbody>
              @foreach($websites as $website)
              <tr>
                <td>{{$website->title}}</td>
                <td>{{$website->theme->theme_id}}</td>
                <td>{{$website->domain}}</td>
                <td>@dateformat($website->created_at)</td>
                <td>${{$website->theme->price}}</td>
              </tr>
               @endforeach
            </tbody> 
          </table>
          
        </div><!-- usage ends -->

      <!-- Automated Payments -->   
      <div id="table-row" class="row automated-payment-row">   
      <!-- Table Title -->      
      <div class="automated-payment-title-wrapper">
        <p class="automated-payment-title">Automated Payments</p> 
      </div>
        <div class="automated-payment-wrapper">   
          <p class="automated-payment-text">I don’t want to make payments manually every month. Please charge me automatically.</p>      
          <div class="yes-no-slider-wrapper">
            <div class="yes-no-slider"></div>
            <p class="yes">YES</p>
            <p class="no">NO</p>
          </div>
        </div>
      </div><!-- Automated Payments ends -->

      <!-- Billing Alerts -->   
      <div id="table-row" class="row billing-alerts-row"> 
      <!-- Table Title -->    
      <div class="billing-alerts-title-wrapper">
        <p class="billing-alerts-title">Billing Alerts</p> 
      </div>    
        <div class="billing-alerts-wrapper">   
          <p class="billing-alerts-text">Send me an email notifications anytime my credit card expires.</p>      
          <div class="yes-no-slider-wrapper">
            <div class="yes-no-slider"></div>
            <p class="yes">YES</p>
            <p class="no">NO</p>
          </div>
        </div>
      </div><!-- Billing Alerts ends -->

      <!-- Payment Method -->
      <div id="table-row" class="row payment-method-row">
      <!-- Table Title -->   
      <div class="payment-method-title-wrapper">
        <p class="payment-method-title">Payment Method</p> 
      </div>
        <div class="payment-method-wrapper">  
          <ul class="nav nav-tabs">
            <p class="payment-method-text">Please enter your preferred payment method below. You can use a credit card or prepay through PayPal.</p>
            <li role="presentation" class="active"><a href="#">STRIPE</a></li>
            <li role="presentation"><a href="#">PAYPALL</a></li>
          </ul>  
        </div>  
      </div>  
      <!-- Billing History -->    
      <div id="table-row" class="row billing-history-row">
      <!-- Table Title -->    
      <div class="billing-history-title-wrapper">
        <p class="billing-history-title">Billing History</p> 
      </div>     
        <div class="billing-history-wrapper">  
          <table class="table">
            <thead>
              <th>Date</th>
              <th>Description</th>
              <th>Amount</th>
            </thead>       
            <tbody>
              <tr>
                <td>October 1, 2016</td>
                <td>Invoice for September</td>
                <td>$75.00</td>
                <td><a href="#" class="view-invoice">View Invoice</a></td>
              </tr>
            </tbody> 
          </table>
        </div>
@endsection