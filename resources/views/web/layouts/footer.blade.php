<footer class="container-fluid remove-padding">
     
    <div class="footer-menu container-fluid remove-padding">
    <div class="container">
       
    <a href="{{ route('home') }}">
                <img src="{{ asset('/assets/front/img/logo2.png') }}">
            </a>
         <ul>
             <li><a href="#">{{__('web.tenders')}}</a></li>
             <li><a href="#">{{__('web.about_us')}}</a></li>
             <li><a href="#">{{__('web.contact_us')}}</a></li>
             <li><a href="#">{{__('web.privacy_policy')}}</a></li>
             <li><a href="#">{{__('web.terms_conditions')}}</a></li>
         </ul>
        </div>
    </div>
        <div class="container-fluid remove-padding copy-main">
            <div class="container">
             <p>© {{date('Y')}} {{ __('web.company_name') }}. {{ __('web.all_rights_reserved') }}</p>
             <ul>
                 <li><a href="{{$facebook_link}}"><i class="ri-facebook-fill"></i></a></li>
                 <li><a href="{{$twitter_link}}"><i class="ri-twitter-x-line"></i></a></li>
                 <li><a href="{{$instagram_link}}"><i class="ri-instagram-fill"></i></a></li>
             </ul>
        </div>
    </div>
</footer>
   
     