    <!-- BEGIN: Footer -->
    @include('layouts.admin.partials.footer-html')
    <!-- END: Footer -->
    
    </div>
    <!-- end:: Page -->
    <!-- begin::Scroll Top -->
    <div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
        <i class="la la-arrow-up"></i>
    </div>
    <!-- end::Scroll Top -->
    <!--begin::Base Scripts -->
    <script src="/templates/metronic/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
    <script src="/templates/metronic/assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
    <!--end::Base Scripts -->
    <!--begin::Page Snippets -->
    <script src="/templates/metronic/assets/app/js/dashboard.js" type="text/javascript"></script>
    
    @stack('custom-js')
    
    <script type="text/javascript">
        
        $('#m_aside_left_minimize_toggle').click(function() {
            if(typeof(Storage) !== 'undefined') {
                setTimeout(function() {
                    localStorage.setItem('bodyClass', $('body').attr('class'));
                    localStorage.setItem('togglerClass', $('#m_aside_left_minimize_toggle').attr('class'));
                }, 1000);
            }
        });

        if(localStorage.bodyClass && localStorage.togglerClass) {
            $('body').attr('class', localStorage.bodyClass);
            $('#m_aside_left_minimize_toggle').attr('class', localStorage.togglerClass);
        }
    </script>

    
    <!--end::Page Snippets -->
</body>
<!-- end::Body -->
</html>