 {{-- Book --}}
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="icon-book"></i>
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu" id="book_list"></ul>
              </li>

 {{-- Layout --}}
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  Layout
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu" id="layout_list">
                  <li><a href="#" onclick="selectLayout('landscape');">Landscape</a></li>
                  <li><a href="#" onclick="selectLayout('compact');">Compact</a></li>
                  <li><a href="#" onclick="selectLayout('compact2');">Compact2</a></li>
                  <li><a href="#" onclick="selectLayout('portrait');">Portrait</a></li>
                </ul>
              </li>

 {{-- Theme --}}
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  Theme 
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu" id="theme_list">
                  <li><a href="#" onclick="selectTheme('default');">Default</a></li>
                  <li><a href="#" onclick="selectTheme('flat');">Flat</a></li>
                  <li><a href="#" onclick="selectTheme('snow');">Snow</a></li>
                </ul>
              </li>
