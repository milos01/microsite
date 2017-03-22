@extends('layouts.home')

@section('contentDashboard')
<div class="container" ng-controller="tokenController"> 
   <div class="row">
    <div class="col-sm-8 add-element-wrapper">
    <!-- Saved forms -->
    <form name="@{{'oldform'+$index}}" ng-repeat="oldForm in oldForms" ng-cloak>
      <div class="element-btns-wrapper" style="margin-bottom: 0px; text-align: left">
            <div class="elements-summary">
              <div class="selected-headline"><p>@{{oldForm.element_type}}: @{{oldForm.url}}</p>
              <div class="edit-element-wrapper">
               <a href="#" ng-click="updateElement($parent.$index, cont)" class="edit-element"></a>
               <a href="#" ng-click="removeElement($parent.$index)" class="remove-element"></a>
              </div>    
              </div>
            </div><!-- add-element-wrapper end -->
      </div>
      <div class="add-element-expanded" style="border-bottom: none">
      <div ng-hide="cont.myValue">
              <p>Please attach files from which developer can use content and paste URL with short explanation where excatly developer should implement content</p>
              <select ui-select2 data-placeholder="Choose site" style="width: 100%;color: #a9a9a9;border-color: #ccc ;background-color: #e9e7e7;font-style: italic;border-radius: 4px" name="userSite" ng-model="oldForm.userSite" required>
                  <option value=""></option>
                  <option ng-repeat="site in sites" value="@{{site.domain}}">@{{site.domain}}</option>
              </select>
              
              <div class="form-group" ng-class="{ 'has-error' : @{{'oldform'+$index}}@{{'oldform'+$index}}.url.$invalid && !@{{'oldform'+$index}}.url.$pristine}">
                <input class="form-control" type="text" id="element-page-url" placeholder="Type or past e URL of the page where content needs to be implemented" name="url" ng-model="oldForm.url" required />
              </div>
              <div class="form-group" ng-class="{ 'has-error' : @{{'oldform'+$index}}.description.$invalid && !@{{'oldform'+$index}}.description.$pristine}">
                <textarea class="form-control" type="text" id="element-section-desc" placeholder="Describe shortly which section" name="description" ng-model="oldForm.description" required ></textarea>
              </div>
            
              <select ui-select2="{minimumResultsForSearch: -1}" name="elType" ng-model="oldForm.elType" data-placeholder="Choose element type: Healdine, Paragraph, Image" style="width: 100%;color: #a9a9a9;border: 0;background-color: #e9e7e7;font-style: italic;border-radius: 10px; margin-top: 20px" ng-change="showExtraFields(oldForm.elType, oldForm)" required>
                  <option value=""></option>
                  <option value="Headline">Headine</option>
                  <option value="Paragraph" >Paragraph</option>
                  <option value="Image">Image</option>
              </select>
                
              <div ng-show="oldForm.showHeadline">
                <div class="form-group" ng-class="{ 'has-error' : @{{'oldform'+$index}}.currentHeadline.$invalid && !@{{'oldform'+$index}}.currentHeadline.$pristine}">
                  <input type="text" class="form-control" id="current-headline" name="currentHeadline" ng-model="oldForm.currentHeadline"  placeholder="Paste current Headline" ng-required="oldForm.elType === 'Headline'" />
                </div>

                <div class="form-group" ng-class="{ 'has-error' : @{{'oldform'+$index}}.newHeadline.$invalid && !@{{'oldform'+$index}}.newHeadline.$pristine}">
                  <input type="text" class="form-control" id="new-headline" name="newHeadline" ng-model="oldForm.newHeadline" placeholder="Type New Headline" ng-required="oldForm.elType === 'Headline'" />
                </div>
              </div> 
              <div ng-show="oldForm.showParagraph">
                <div class="form-group" ng-class="{ 'has-error' : @{{'oldform'+$index}}.currentParagraph.$invalid && !@{{'oldform'+$index}}.currentParagraph.$pristine}">
                  <textarea id="current-paragraph" class="form-control" name="currentParagraph" ng-model="oldForm.currentParagraph" placeholder="Paste Current Paragraph Text" ng-required="oldForm.elType === 'Paragraph'"></textarea>
                </div>
                <div class="form-group" ng-class="{ 'has-error' : @{{'oldform'+$index}}.newParagraph.$invalid && !@{{'oldform'+$index}}.newParagraph.$pristine}">
                  <textarea id="new-paragraph" class="form-control" name="newParagraph" ng-model="oldForm.newParagraph" placeholder="Paste New Paragraph Text" ng-required="oldForm.elType === 'Paragraph'"></textarea>
                </div>
              </div>
              <div ng-show="oldForm.showImage">
                <div class="drag-drop-area">
                   <p>DRAG AND DROP FILE</p>
                   <label class="upload-label">
                   <input type="file" name="file" />
                   <span>Upload From</span>
                   </label>
                </div>
              </div>
              <div class="element-btns-wrapper" ng-hide="cont.myValue" style="border-bottom: 1px solid #d8d8d8; padding-bottom: 50px">
                <!-- <button class="btn btn-default element-cancel-btn">CANCEL</button> -->
                <button class="btn btn-default element-save-btn" ng-click="saveElement(oldForm)" ng-disabled="@{{'oldform'+$index}}.$invalid">SAVE</button>
              </div>
          </div>
          </div>
    </form>
    <!-- End saved forms -->
    <form name="@{{form.name}}"
          ng-repeat="form in forms" ng-cloak>
          <div class="add-element-expanded" ng-repeat="cont in form.contacts" style="border-bottom: none">
            <div ng-hide="cont.myValue">
              <p>Please attach files from which developer can use content and paste URL with short explanation where excatly developer should implement content</p>
              <select ui-select2 data-placeholder="Choose site" style="width: 100%;color: #a9a9a9;border-color: #ccc ;background-color: #e9e7e7;font-style: italic;border-radius: 4px" name="userSite" ng-model="cont.userSite" required>
                  <option value=""></option>
                  <option ng-repeat="site in sites" value="@{{site.domain}}">@{{site.domain}}</option>
              </select>
              
              <div class="form-group" ng-class="{ 'has-error' : @{{form.name}}.url.$invalid && !@{{form.name}}.url.$pristine}">
                <input class="form-control" type="text" id="element-page-url" placeholder="Type or past e URL of the page where content needs to be implemented" name="url" ng-model="cont.url" required />
              </div>
              <div class="form-group" ng-class="{ 'has-error' : @{{form.name}}.description.$invalid && !@{{form.name}}.description.$pristine}">
                <textarea class="form-control" type="text" id="element-section-desc" placeholder="Describe shortly which section" name="description" ng-model="cont.description" required ></textarea>
              </div>
            
              <select ui-select2="{minimumResultsForSearch: -1}" name="elType" ng-model="cont.elType" data-placeholder="Choose element type: Healdine, Paragraph, Image" style="width: 100%;color: #a9a9a9;border: 0;background-color: #e9e7e7;font-style: italic;border-radius: 10px; margin-top: 20px" ng-change="showExtraFields(cont.elType, cont)" required>
                  <option value=""></option>
                  <option value="Headline">Headine</option>
                  <option value="Paragraph">Paragraph</option>
                  <option value="Image">Image</option>
              </select>
                
              <div ng-show="cont.showHeadline">
                <div class="form-group" ng-class="{ 'has-error' : @{{form.name}}.currentHeadline.$invalid && !@{{form.name}}.currentHeadline.$pristine}">
                  <input type="text" class="form-control" id="current-headline" name="currentHeadline" ng-model="cont.currentHeadline" placeholder="Paste current Headline" ng-required="cont.elType === 'Headline'" />
                </div>

                <div class="form-group" ng-class="{ 'has-error' : @{{form.name}}.newHeadline.$invalid && !@{{form.name}}.newHeadline.$pristine}">
                  <input type="text" class="form-control" id="new-headline" name="newHeadline" ng-model="cont.newHeadline" placeholder="Type New Headline" ng-required="cont.elType === 'Headline'" />
                </div>
              </div> 
              <div ng-show="cont.showParagraph">
                <div class="form-group" ng-class="{ 'has-error' : @{{form.name}}.currentParagraph.$invalid && !@{{form.name}}.currentParagraph.$pristine}">
                  <textarea id="current-paragraph" class="form-control" name="currentParagraph" ng-model="cont.currentParagraph" placeholder="Paste Current Paragraph Text" ng-required="cont.elType === 'Paragraph'"></textarea>
                </div>
                <div class="form-group" ng-class="{ 'has-error' : @{{form.name}}.newParagraph.$invalid && !@{{form.name}}.newParagraph.$pristine}">
                  <textarea id="new-paragraph" class="form-control" name="newParagraph" ng-model="cont.newParagraph" placeholder="Paste New Paragraph Text" ng-required="cont.elType === 'Paragraph'"></textarea>
                </div>
              </div>
              <div ng-show="cont.showImage">
                <div class="drag-drop-area">
                   <p>DRAG AND DROP FILE</p>
                   <label class="upload-label">
                   <input type="file" name="file" />
                   <span>Upload From</span>
                   </label>
                </div>
              </div>
              
          </div>
          <div class="element-btns-wrapper" ng-hide="cont.myValue" style="border-bottom: 1px solid #d8d8d8; padding-bottom: 50px">
                <!-- <button class="btn btn-default element-cancel-btn">CANCEL</button> -->
                <button class="btn btn-default element-save-btn" ng-click="saveElement(form, cont)" ng-disabled="@{{form.name}}.$invalid">SAVE</button>
          </div>
          <div class="element-btns-wrapper" ng-show="cont.myValue" style="margin-bottom: 0px; text-align: left">
                <div class="elements-summary">
                  <div class="selected-headline"><p>@{{cont.elType}}: @{{cont.url}}</p>
                  <div class="edit-element-wrapper">
                   <a href="#" ng-click="updateElement($parent.$index, cont)" class="edit-element"></a>
                   <a href="#" ng-click="removeElement($parent.$index)" class="remove-element"></a>
                  </div>    
                  </div>
                </div><!-- add-element-wrapper end -->
          </div>
        </div>
    </form>
      <button type="button" class="btn btn-default add-element" ng-click="addElement()"><span class="element-plus">+</span>Add Element</button>
      </div>



    <div class="col-sm-4 tokens-summary-wrapper">
          <h1 class="token-summary-title" style="margin-top: 20px">Summary</h1>
           <div class="tokens-price-wrapper">
            <p class="summary-single-price" ng-repeat="receve in receves" ng-cloak>@{{receve.type}}  <span>$@{{receve.price}}</span></p>
           </div>
           <div clasas="tokens-total-wrapper">
             <p class="total-price" >Total: <span ng-model="totalPrice" ng-bind="getTotal()"></span></p>
             <a href="{!! route('tokenPaymentPage') !!}" type="submit" class="btn btn-default summary-checkout-btn" ng-hide="receves.length === 0" ng-cloak>CHECKOUT</a>
           </div>
  </div> 
  </div>
  </div>
@endsection
