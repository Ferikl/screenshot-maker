@extends('layouts.app')

@section('css')
    <style>
        .vertical-center {
            margin-top:3%;
        }
        .screenshot-wrapper {
            padding-top: 100px;
        }
        #siteurl {
            width: 350px;
        }
        .hidden {
            display: none;
        }
        .img-thumbnail {
            max-height: 500px;
        }
    </style>
@endsection

@section('content')
    <div class="vertical-center">
        <div class="container text-center">
            <form class="form-inline">
                <div class="form-group">
                    <label for="siteurl" class="sr-only">Site URL</label>
                    <input type="text" class="form-control" id="siteurl" name="siteurl" placeholder="Site URL">
                </div>
                <button type="button" class="btn btn-default js_make-screenshot">Make Screenshot</button>
            </form>
            <div class="screenshot-wrapper"></div>
            <img class="js_loader hidden" src="/images/loader.gif" alt="loader"/>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var ScreenshotMaker = function() {
            var self = this;
            self.init = function() {
                $.ajaxSetup({
                    headers:
                        { 'X-CSRF-TOKEN': window.Laravel.csrfToken }
                });
                
                $('.js_make-screenshot').on('click', function(e){
                    self.getScreenshot();
                });
            };
            
            self.getScreenshot = function(e) {
                var siteUrl = $('#siteurl').val();
                
                if (!siteUrl.length) {
                    alert('Please Enter Site URL');
                    return false;
                }
                
                $.ajax({
                    url: '/getScreenshot',
                    type: 'POST',
                    data: {
                        url: siteUrl
                    },
                    beforeSend: function() {
                        $('.js_loader').toggleClass('hidden');
                    },
                    success: function(response) {
                        console.log('success: ', response);
                        $('.js_loader').toggleClass('hidden');
                        
                        if (!response.success) {
                            alert(response.error);
                            return false;
                        }
                        
                        console.log('response: ', response);
                        
                        html = '<a href="'+ response.data.download_link +'" target="_blank"><img class="img-thumbnail" src="'+ response.data.view_link +'"></a>';
                        
                        $('.screenshot-wrapper').html(html);
                        $('.sites-wrapper').toggleClass('hidden');
                    },
                    error: function(response) {
                        console.log('error: ', response);
                        $('.js_loader').toggleClass('hidden');
                        alert(response);
                    }
                    
                });
            };
            
            self.init();
        };
        
        $(document).ready(function(){
            var screenshotMaker = new ScreenshotMaker();
        });
    
    </script>
@endsection
