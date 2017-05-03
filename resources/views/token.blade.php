@extends('layouts.home')

@section('contentDashboard')
<div class="container">    
    <div class="page-header"><h1>Tokens</h1></div>

    <div class="row">
     <!-- Token Site Setup -->   
      <div class="col-sm-6 col-md-4">
        <div class="token-wrapper">
          <div id="token-link-redirect" class="token-header">
            <p class="token-title">Site Setup</p>
            <div class="token-price-wrapper">
              <p class="token-price">500&euro;</p>
              <p class="per-element">one time action</p>
            </div>
          </div>
          <div class="token-body">
            <p class="token-text">Site setup is one time action. Micro Medic support team will redesign layout of website sample you picked using your brand standards, redirect domain, setup 301 redirect (if necessary) and setup payment gateway.</p>
            
          </div>
          <div class="token-footer">
            <button type="button" class="btn btn-primary btn-lg token-button" data-toggle="modal" data-target="#mymodal">PROCEED<span class=""></span></button>
          </div>
        </div>
      </div><!-- Token Site Setup end -->  
   

      <!-- Token Basic SEO -->   
      <div class="col-sm-6 col-md-4">
        <div class="token-wrapper">
          <div id="token-header-seo" class="token-header">
            <p class="token-title">Basic SEO Setup</p>
            <div class="token-price-wrapper">
              <p class="token-price">250&euro;</p>
              <p class="per-element">one time action</p>
            </div>
          </div>
          <div class="token-body">
               <p class="token-text">Basic SEO Setup is one time action where Micro Medic support team will install necessary SEO plugins and configure your website for best SEO performance.</p>
            <p class="token-text">For more information please click here. </p>
          </div>
          <div class="token-footer">
            <button type="button" class="btn btn-primary btn-lg token-button" data-toggle="modal" data-target="#mymodal">PROCEED<span class=""></span></button>
          </div>
        </div>
      </div><!-- Token Basic SEO end -->  


      <!-- Token Content Update -->   
      <div class="col-sm-6 col-md-4 token-columns">
        <div class="token-wrapper">
          <div class="token-header">
            <p class="token-title">Content Update</p>
            <div class="token-price-wrapper">
              <p class="token-price">$5</p>
              <p class="per-element">per element</p>
            </div>
          </div>
          <div class="token-body">
            <p class="token-text">By submiting content through content update process one of our support members will be assigned to you in order to implement content for you.</p>
            <p class="token-text"><strong>One element is equal to:</strong><br><i>1 image, 1 headline or 1 paragraph.</i></p>
          </div>
          <div class="token-footer">
            <a href="{!! route('elements') !!}" type="button" class="btn btn-primary btn-lg token-button">PROCEED<span class=""></span></a>
          </div>
        </div>
      </div><!-- Token Content Update end -->   
</div>
</div>
@endsection
