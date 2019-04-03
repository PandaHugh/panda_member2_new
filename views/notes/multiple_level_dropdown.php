<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <ul class="sidebar-menu">

      <?php
      //query mother
      $mother = $this->db->query("SELECT Description, ChildNode from mrpreport.report where MotherNode='MAIN' order by RepOrder");

      foreach($mother->result() as $row) { ?>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i> <span><b><?php echo "[",$row->ChildNode,"] ", $row->Description?></b></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <!-- child 1 foreach -->             
          <?php
          $i = 0;
          //query child of mother
          $child = $this->db->query("SELECT Description, ChildNode from mrpreport.report where MotherNode='$row->ChildNode' order by RepOrder");

          foreach($child->result() as $row2) { ?>

            <li>
              <!-- ++$i is the way to show query output data with increment number -->
              <a href="#"><i class="fa fa-share"><b></i><?php echo ++$i ?>.&nbsp<?php echo "[",$row2->ChildNode,"] ", $row2->Description?></b>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
              <!-- child 2 foreach -->
              <?php
              $j = 0;
              //query child2 of child
              $child2 = $this->db->query("SELECT Description, Module_Link, ChildNode from mrpreport.report where MotherNode='$row2->ChildNode' order by RepOrder");

              foreach($child2->result() as $row3) { ?>

                <li>
                  <a href="<?php echo site_url($row3->Module_Link)?>"><i class="fa fa-circle-o"></i><b><?php echo ++$j ?>.&nbsp<?php echo "[",$row3->ChildNode,"] ", $row3->Description?></b>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <!-- end child 2 -->
                </li>
                <?php } ?>
              </ul>
              <!-- end child 1 -->
            </li>
            <?php } ?>
          </ul>
          <!-- End Parent -->
        </li>
        <?php } ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>