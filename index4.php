<!doctype html>
<html>
<?php 
require_once('init.php');
$css='css/index_spec.css';
$naslov_short="Bookmaking";
$naslov="Bookmaking osnovna strana";


include(join(DIRECTORY_SEPARATOR, array('included', 'main_header.php')));

?>
    <body>
        <div id="container">
            <?php $btn1='index.php';$btn2='Podrska/index.php';$btn3='Teletext/index.php';$btn4='Verif/index.php';
            include(join(DIRECTORY_SEPARATOR, array('included', 'main_menu.php')));?> 
            <div id="function_data">
                <div class="content">
                  <h1>Responsive Organization Chart</h1>
                  <figure class="org-chart cf">
                    <ul class="administration">
                      <li>                  
                        <ul class="director">
                          <li>
                            <a href="#"><span>Director</span></a>
                            <ul class="subdirector">
                              <li><a href="#"><span>Assistante Director</span></a></li>
                            </ul>
                            <ul class="departments cf">                             
                              <li><a href="#"><span>Administration</span></a></li>
                              
                              <li class="department dep-a">
                                <a href="#"><span>Department A</span></a>
                                <ul class="sections">
                                  <li class="section"><a href="#"><span>Section A1</span></a></li>
                                  <li class="section"><a href="#"><span>Section A2</span></a></li>
                                  <li class="section"><a href="#"><span>Section A3</span></a></li>
                                  <li class="section"><a href="#"><span>Section A4</span></a></li>
                                  <li class="section"><a href="#"><span>Section A5</span></a></li>
                                </ul>
                              </li>
                              <li class="department dep-b">
                                <a href="#"><span>Department B</span></a>
                                <ul class="sections">
                                  <li class="section"><a href="#"><span>Section B1</span></a></li>
                                  <li class="section"><a href="#"><span>Section B2</span></a></li>
                                  <li class="section"><a href="#"><span>Section B3</span></a></li>
                                  <li class="section"><a href="#"><span>Section B4</span></a></li>
                                </ul>
                              </li>
                              <li class="department dep-c">
                                <a href="#"><span>Department C</span></a>
                                <ul class="sections">
                                  <li class="section"><a href="#"><span>Section C1</span></a></li>
                                  <li class="section"><a href="#"><span>Section C2</span></a></li>
                                  <li class="section"><a href="#"><span>Section C3</span></a></li>
                                  <li class="section"><a href="#"><span>Section C4</span></a></li>
                                </ul>
                              </li>
                              <li class="department dep-d">
                                <a href="#"><span>Department D</span></a>
                                <ul class="sections">
                                  <li class="section"><a href="#"><span>Section D1</span></a></li>
                                  <li class="section"><a href="#"><span>Section D2</span></a></li>
                                  <li class="section"><a href="#"><span>Section D3</span></a></li>
                                  <li class="section"><a href="#"><span>Section D4</span></a></li>
                                  <li class="section"><a href="#"><span>Section D5</span></a></li>
                                  <li class="section"><a href="#"><span>Section D6</span></a></li>
                                </ul>
                              </li>
                              <li class="department dep-e">
                                <a href="#"><span>Department E</span></a>
                                <ul class="sections">
                                  <li class="section"><a href="#"><span>Section E1</span></a></li>
                                  <li class="section"><a href="#"><span>Section E2</span></a></li>
                                  <li class="section"><a href="#"><span>Section E3</span></a></li>
                                </ul>
                              </li>
                              <li class="department dep-e">
                                <a href="#"><span>Department E</span></a>
                                <ul class="sections">
                                  <li class="section"><a href="#"><span>Section E1</span></a></li>
                                  <li class="section"><a href="#"><span>Section E2</span></a></li>
                                  <li class="section"><a href="#"><span>Section E3</span></a></li>
                                </ul>
                              </li>
                            </ul>
                          </li>
                        </ul>   
                      </li>
                    </ul>           
                  </figure>
                </div>
            </div>
            <?php include(join(DIRECTORY_SEPARATOR, array('included', 'main_footer.php'))); ?>
        </div>
    </body>
</html>