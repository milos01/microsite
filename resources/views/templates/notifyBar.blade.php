  @if(isset($userTrial))
    <div class="notification-trial-bar">
      <p class="notification-trial">You Free Trial expires in<span class="trial-number">    {{$userTrial}} days</span>. Please  upgrade your account on time in order to avoid stopping your site development.</p>
      <!-- <button type="submit" id="upgrade-button" class="btn btn-default">UPGRADE</button> -->
    </div>
    @elseif(isset($userTrialExpired))
    <div class="notification-trial-bar">
      <p class="notification-trial">You Free Trial expired. Please  go to billing page to make payment.</p>
      <a href="{!! route('billing') !!}" type="submit" id="upgrade-button" class="btn btn-default">Billing</a>
    </div>
    @endif