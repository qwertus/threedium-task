<!-- begin::Footer -->
<footer class="m-grid__item m-footer">
    <div class="m-container m-container--fluid m-container--full-height m-page__container">
        <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
            <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
                <span class="m-footer__copyright">
                    <?php
                        
                        if(date("Y") > 2017){
                            echo "2017 - " . date("Y");
                        }else{
                            echo "2017";
                        }
                    ?>
                    &copy; 
                    
                    {{ trans('admin.copyrights') }}
                    
                </span>
            </div>
            <div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
                <ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
                    <li class="m-nav__item">
                        <a href="https://www.linkedin.com/in/vitomir-petrovic-507877160/" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <small>Developed by: </small>Vitomir Petrovic
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- end::Footer -->