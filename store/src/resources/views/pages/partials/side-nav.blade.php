<header class=" z-depth-1  flex-md-row  container" style="background-color:#23a393; margin-top:10px; margin-bottom:10px; border-top-left-radius:30%;border-bottom-right-radius:20%; border-width:3px; border-right:3px solid #383838;  border-left:3px solid #383838;">
    
  
        <div class="container">
          <ul  style="display:flex; justify-content:space-around; align-items: center;  ">
            
          <li >
          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  Brands <span class="caret"></span>
                  <ul class="dropdown-menu">
                      @foreach($brands as $brand)
                          <li >
                              <a href="{{ url('brand', $brand->id) }}">
                                  {{ $brand->brand_name }}
                              </a>
                          </li>
                      @endforeach
                  </ul>
              </a>
          </li>
          </li>
    
          <br><br>
    
          @foreach($categories as $category)
              <li>
                  <li class="dropdown ">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                          {{ $category->category }} <span class="caret"></span>
                          <ul class="dropdown-menu">
                              @foreach($category->children as $children)
                                  <li>
                                      <a href="{{ url('category', $children->id) }}">
                                          {{ $children->category }}
                                      </a>
                                  </li>
                              @endforeach
                          </ul>
                      </a>
                  </li>
              </li>
          @endforeach
    
          <br><br>
    
          <li>
              <a class="text-white bg-dark" href="{{ url('admin/dashboard') }}">
                  ADMIN
              </a>
          </li>
    
          </ul>
        </div>
    </header>