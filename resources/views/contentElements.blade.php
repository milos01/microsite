@extends('layouts.home')

@section('contentDashboard')
<div class="container"> 
   <div class="row">
    <div class="col-sm-8 add-element-wrapper">
     <div class="add-element-expanded">
      <p>Please attach files from which developer can use content and paste URL with short explanation where excatly developer should implement content</p>
       <input type="text" id="element-page-url" name="element-page-url" placeholder="Type or past e URL of the page where content needs to be implemented" onfocus="this.placeholder = ''"/>
       <input type="text" id="element-section-desc" name="element-section-desc" placeholder="Describe shortly which section" onfocus="this.placeholder = ''"/>
      <select>
        <option value="" disabled selected>Choose element type: Healdine, Paragraph, Image</option>
        <option value="healdine">Healdine</option>
        <option value="paragraph">Paragraph</option>
        <option value="image">Image</option>
      </select>
       <div class="element-btns-wrapper">
        <button class="btn btn-default element-cancel-btn">CANCEL</button>
        <button class="btn btn-default element-save-btn">SAVE</button>
      </div>
      </div>
      <button type="button" class="btn btn-default add-element"><span class="element-plus">+</span>Add Element</button>
      </div>
    <div class="col-sm-4 tokens-summary-wrapper">
      <h1 class="token-summary-title">Summary</h1>
       <div class="tokens-price-wrapper">
        <p class="summary-single-price">Headline  <span>$5</span></p>
        <p class="summary-single-price">Image  <span>$5</span></p>
       </div>
       <div clasas="tokens-total-wrapper">
         <p class="total-price">Total: <span>$10</span></p>
         <button type="submit" class="btn btn-default summary-checkout-btn">CHECKOUT</button>
       </div>
      
  </div> 
  </div>
  </div>
@endsection
