<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-light">
    <!-- BEGIN: Aside Menu -->
    <div 
        id="m_ver_menu" 
        class="m-aside-menu  m-aside-menu--skin-light m-aside-menu--submenu-skin-light m-aside-menu--dropdown " 
        data-menu-vertical="true"
        data-menu-dropdown="true" data-menu-scrollable="true" data-menu-dropdown-timeout="500"  
        >
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow pt-0">
            <?php
//            <li class="m-menu__section">
//                <h4 class="m-menu__section-text">
//                  CMS
//                </h4>
//            <i class="m-menu__section-icon flaticon-more-v3"></i>
//            </li>
//            
//            <li class="m-menu__item m-menu__item--@sidebar::active('home')"  aria-haspopup="true" >
//                <a  href="{{ route('home') }}" class="m-menu__link ">
//                    <span class="m-menu__item-here"></span>
//                    <i class="m-menu__link-icon flaticon-line-graph"></i>
//                    <span class="m-menu__link-text">
//                         Dashboard 
//                    </span>
//                </a>
//            </li>
            ?>
            <li class="m-menu__section">
                <h4 class="m-menu__section-text">
                  Articles
                </h4>
            <i class="m-menu__section-icon flaticon-more-v3"></i>
            </li>
            <li class="m-menu__item m-menu__item--@sidebar::active('articles','index')"  aria-haspopup="true" >
                <a  href="{{ route('articles.index') }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-list-1"></i>
                    <span class="m-menu__link-text">
                         List 
                    </span>
                </a>
            </li>
            <li class="m-menu__item m-menu__item--@sidebar::active('articles','create')"  aria-haspopup="true" >
                <a  href="{{ route('articles.create') }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-plus"></i>
                    <span class="m-menu__link-text">
                         Create 
                    </span>
                </a>
            </li>
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>